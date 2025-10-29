# Docker Setup Guide for Elixer Dashboard

Complete step-by-step guide to run the Elixer Dashboard Laravel application using Docker.

---

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Initial Setup](#initial-setup)
3. [Running the Application](#running-the-application)
4. [First Time Setup Commands](#first-time-setup-commands)
5. [Common Issues & Solutions](#common-issues--solutions)
6. [Useful Docker Commands](#useful-docker-commands)
7. [Accessing Services](#accessing-services)
8. [Development Workflow](#development-workflow)

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed on your system:

- **Docker Desktop** (version 20.10 or higher)
  - Download from: https://www.docker.com/products/docker-desktop
  - Start Docker Desktop before proceeding

- **Docker Compose** (version 1.29 or higher)
  - Usually included with Docker Desktop

- **Git** (to clone the repository if needed)

Verify your installation:
```bash
docker --version
docker-compose --version
```

---

## 🚀 Initial Setup

### Step 1: Navigate to Project Directory

```bash
cd /Users/mosabahmed/Documents/GitHub/dashboard.elixer.com
```

### Step 2: Create Environment File

Copy the Docker environment example file:

```bash
cp env.docker.example .env
```

This creates a `.env` file with Docker-optimized settings including:
- Database connection to Docker MySQL container
- Redis connection to Docker Redis container
- Appropriate URLs and ports

### Step 3: Review Environment Configuration

Edit the `.env` file if needed:

```bash
# Database Configuration (Docker-specific)
DB_CONNECTION=mysql
DB_HOST=db              # Use 'db' (Docker service name)
DB_PORT=3306
DB_DATABASE=elixer_db
DB_USERNAME=root
DB_PASSWORD=root

# Redis Configuration (Docker-specific)
REDIS_HOST=redis        # Use 'redis' (Docker service name)
REDIS_PORT=6379
```

---

## 🏃 Running the Application

### Option 1: Quick Start with Automated Script

Use the provided setup script for easy installation:

```bash
./docker-start.sh
```

This script will:
- Create `.env` file if it doesn't exist
- Build and start Docker containers
- Install Composer dependencies
- Install NPM dependencies
- Generate application key
- Set proper permissions
- Ask to run migrations and seeders

### Option 2: Manual Setup

#### Build and Start Containers

```bash
docker-compose up -d --build
```

This command:
- Builds the PHP application container from Dockerfile
- Creates all necessary containers (PHP, Nginx, MySQL, PHPMyAdmin, Redis)
- Starts them in detached mode (background)

#### Verify Containers are Running

```bash
docker-compose ps
```

You should see 5 containers running:
- `elixer_app` (PHP 8.3-FPM)
- `elixer_webserver` (Nginx)
- `elixer_db` (MySQL 8.0)
- `elixer_phpmyadmin` (PHPMyAdmin)
- `elixer_redis` (Redis)

---

## 🔧 First Time Setup Commands

After containers are running, execute these commands:

### 1. Install PHP Dependencies

```bash
docker-compose exec app composer install
```

This installs all Laravel dependencies from `composer.json`.

### 2. Install NPM Dependencies

```bash
docker-compose exec app npm install
```

This installs all JavaScript dependencies from `package.json`.

### 3. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

This generates a unique encryption key for your application.

### 4. Set Storage Permissions

```bash
docker-compose exec app chmod -R 775 storage
docker-compose exec app chmod -R 775 bootstrap/cache
```

This ensures Laravel can write to storage and cache directories.

### 5. Run Database Migrations

```bash
docker-compose exec app php artisan migrate
```

This creates all necessary database tables.

**Note:** If you get an error about the `sessions` table, it means the migration was created. You can skip this step as it's now included in the migrations.

### 6. Seed Database (Optional)

```bash
docker-compose exec app php artisan db:seed
```

This populates your database with initial data (users, roles, settings, etc.).

### 7. Build Frontend Assets (Optional)

```bash
docker-compose exec app npm run build
```

This compiles your frontend assets for production use.

---

## ❗ Common Issues & Solutions

### Issue 1: PHP Version Error

**Error:**
```
Composer detected issues in your platform: 
Your Composer dependencies require a PHP version ">= 8.3.0". 
You are running 8.1.33.
```

**Solution:**

1. Update the Dockerfile to use PHP 8.3:
   - Open `Dockerfile`
   - Change line 1 from `FROM php:8.1-fpm` to `FROM php:8.3-fpm`

2. Update composer.json:
   - Open `composer.json`
   - Change `"php": "^8.1"` to `"php": "^8.3"`

3. Rebuild containers:
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

4. Install dependencies:
   ```bash
   docker-compose exec app composer install
   ```

**Status:** ✅ Fixed in this setup

---

### Issue 2: Missing Sessions Table

**Error:**
```
SQLSTATE[42S02]: Base table or view not found: 
1146 Table 'elixer_db.sessions' doesn't exist
```

**Root Cause:**
Laravel is configured to use `database` driver for sessions, but the migration file was missing.

**Solution:**

1. Create the sessions migration:
   ```bash
   docker-compose exec app php artisan make:migration create_sessions_table
   ```

2. Edit the created migration file:
   Open: `database/migrations/XXXX_XX_XX_XXXXXX_create_sessions_table.php`

   Replace the `up()` method with:
   ```php
   public function up(): void
   {
       Schema::create('sessions', function (Blueprint $table) {
           $table->string('id')->primary();
           $table->foreignId('user_id')->nullable()->index();
           $table->string('ip_address', 45)->nullable();
           $table->text('user_agent')->nullable();
           $table->longText('payload');
           $table->integer('last_activity')->index();
       });
   }
   ```

3. Run the migration:
   ```bash
   docker-compose exec app php artisan migrate
   ```

**Status:** ✅ Fixed in this setup (migration file already created)

---

### Issue 3: Permission Errors

**Error:**
```
The stream or file could not be opened in append mode: 
Failed to open stream: Permission denied
```

**Solution:**
```bash
docker-compose exec app chmod -R 775 storage
docker-compose exec app chmod -R 775 bootstrap/cache
```

---

### Issue 4: Port Already in Use

**Error:**
```
Bind for 0.0.0.0:8000 failed: port is already allocated
```

**Solution:**

Edit `docker-compose.yml` and change the ports:

```yaml
webserver:
  ports:
    - "8001:80"  # Change 8000 to another port like 8001
```

Then restart containers:
```bash
docker-compose down
docker-compose up -d
```

---

### Issue 5: Database Connection Failed

**Error:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solution:**

1. Check if database container is running:
   ```bash
   docker-compose ps db
   ```

2. Check database logs:
   ```bash
   docker-compose logs db
   ```

3. Ensure `.env` file has correct database host:
   ```env
   DB_HOST=db  # Not '127.0.0.1' or 'localhost'
   ```

4. Restart containers:
   ```bash
   docker-compose restart
   ```

---

### Issue 6: Composer Lock File Warning

**Error:**
```
The lock file is not up to date with the latest changes in composer.json
```

**Solution:**

Update the lock file:
```bash
docker-compose exec app composer update --lock
```

---

## 🛠️ Useful Docker Commands

### Container Management

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose stop

# Restart containers
docker-compose restart

# Stop and remove containers
docker-compose down

# View running containers
docker-compose ps

# View container logs
docker-compose logs -f

# View logs for specific service
docker-compose logs -f app
docker-compose logs -f webserver
docker-compose logs -f db
```

### Accessing Containers

```bash
# Execute PHP Artisan commands
docker-compose exec app php artisan {command}

# Execute Composer commands
docker-compose exec app composer {command}

# Execute NPM commands
docker-compose exec app npm {command}

# Access shell in app container
docker-compose exec app bash

# Access MySQL shell
docker-compose exec db mysql -u root -p
```

### Laravel Commands

```bash
# Clear all caches
docker-compose exec app php artisan optimize:clear

# Clear config cache
docker-compose exec app php artisan config:clear

# Clear route cache
docker-compose exec app php artisan route:clear

# Clear view cache
docker-compose exec app php artisan view:clear

# Cache configuration
docker-compose exec app php artisan config:cache

# Run migrations
docker-compose exec app php artisan migrate

# Rollback last migration
docker-compose exec app php artisan migrate:rollback

# Run seeders
docker-compose exec app php artisan db:seed

# Run queue worker
docker-compose exec app php artisan queue:work

# List all routes
docker-compose exec app php artisan route:list
```

### Debugging

```bash
# View PHP version
docker-compose exec app php -v

# View installed PHP extensions
docker-compose exec app php -m

# Check database connection
docker-compose exec app php artisan db:show

# Test database connection
docker-compose exec app php artisan tinker
# Then in tinker: DB::connection()->getPdo();
```

---

## 🌐 Accessing Services

### Web Application
- **URL:** http://localhost:8000
- **Description:** Main Laravel application

### PHPMyAdmin (Database Management)
- **URL:** http://localhost:8080
- **Username:** `root`
- **Password:** `root`
- **Server:** `db`
- **Description:** Web-based MySQL administration tool

### Database Direct Access
- **Host:** `localhost`
- **Port:** `3306`
- **Database:** `elixer_db`
- **Username:** `root`
- **Password:** `root`

### Redis
- **Host:** `localhost`
- **Port:** `6379`

---

## 🔄 Development Workflow

### Making Code Changes

1. **Edit files locally** in your IDE
2. Changes are automatically reflected (volumes are mounted)
3. **Clear caches** if needed:
   ```bash
   docker-compose exec app php artisan optimize:clear
   ```

### Adding New PHP Dependencies

```bash
# Install new package
docker-compose exec app composer require vendor/package-name

# Update all packages
docker-compose exec app composer update
```

### Adding New NPM Dependencies

```bash
# Install new package
docker-compose exec app npm install package-name

# Build assets
docker-compose exec app npm run build
```

### Database Changes

```bash
# Create new migration
docker-compose exec app php artisan make:migration create_example_table

# Edit the migration file
# Then run migrations
docker-compose exec app php artisan migrate
```

### Updating Environment Variables

```bash
# Edit .env file
nano .env

# Clear config cache to apply changes
docker-compose exec app php artisan config:clear
```

### Debugging Application Errors

1. **Check Laravel logs:**
   ```bash
   docker-compose exec app tail -f storage/logs/laravel.log
   ```

2. **Check Nginx error logs:**
   ```bash
   docker-compose logs webserver
   ```

3. **Check PHP error logs:**
   ```bash
   docker-compose logs app
   ```

---

## 🗑️ Clean Up

### Stop and Remove Everything

```bash
# Stop containers (keeps data in volumes)
docker-compose down

# Stop and remove everything including volumes (WARNING: Deletes database data!)
docker-compose down -v
```

### Reset Database

```bash
# Drop all tables and re-run migrations
docker-compose exec app php artisan migrate:fresh

# Drop all tables, re-run migrations, and seed
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 📝 Quick Reference

### Complete Setup from Scratch

```bash
# 1. Navigate to project
cd /Users/mosabahmed/Documents/GitHub/dashboard.elixer.com

# 2. Copy environment file
cp env.docker.example .env

# 3. Start containers
docker-compose up -d --build

# 4. Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# 5. Generate key
docker-compose exec app php artisan key:generate

# 6. Set permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache

# 7. Run migrations
docker-compose exec app php artisan migrate

# 8. Seed database (optional)
docker-compose exec app php artisan db:seed

# 9. Build assets (optional)
docker-compose exec app npm run build

# 10. Access application
# Open: http://localhost:8000
```

### Daily Development

```bash
# Start containers
docker-compose up -d

# Stop containers at end of day
docker-compose stop

# View logs if issues
docker-compose logs -f

# Clear cache if needed
docker-compose exec app php artisan optimize:clear
```

---

## 🎯 Summary of Issues Resolved

1. ✅ **PHP Version Error** - Updated to PHP 8.3
2. ✅ **Sessions Table Missing** - Created migration file
3. ✅ **Container Configuration** - Proper Docker setup
4. ✅ **Database Connection** - Correct host configuration
5. ✅ **File Permissions** - Proper directory permissions

---

## 📞 Need Help?

If you encounter issues not covered here:

1. Check container logs: `docker-compose logs -f`
2. Verify all containers are running: `docker-compose ps`
3. Check application logs: `storage/logs/laravel.log`
4. Ensure `.env` file is properly configured

---

**Happy Coding! 🚀**

