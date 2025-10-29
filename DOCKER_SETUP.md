# Docker Setup Guide for Elixer Dashboard

This guide will help you set up and run the Elixer Dashboard application using Docker.

## Prerequisites

- Docker (version 20.10 or higher)
- Docker Compose (version 1.29 or higher)

## Quick Start

### 1. Clone and Navigate to Project

```bash
cd /Users/mosabahmed/Documents/GitHub/dashboard.elixer.com
```

### 2. Setup Environment File

Copy the Docker environment example file:

```bash
cp env.docker.example .env
```

Or manually create a `.env` file with the following key configurations for Docker:

```env
APP_NAME="Elixer Dashboard"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=elixer_db
DB_USERNAME=root
DB_PASSWORD=root

REDIS_HOST=redis
REDIS_PORT=6379
```

### 3. Build and Start Docker Containers

```bash
docker-compose up -d --build
```

This command will:
- Build the PHP application container
- Start MySQL database (port 3306)
- Start Nginx web server (port 8000)
- Start PHPMyAdmin (port 8080)
- Start Redis (port 6379)

### 4. Install Dependencies

```bash
# Install PHP dependencies
docker-compose exec app composer install

# Install NPM dependencies
docker-compose exec app npm install
```

### 5. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

### 6. Run Database Migrations

```bash
docker-compose exec app php artisan migrate
```

### 7. (Optional) Seed Database

```bash
docker-compose exec app php artisan db:seed
```

### 8. (Optional) Build Frontend Assets

```bash
docker-compose exec app npm run build
```

## Access the Application

- **Web Application**: http://localhost:8000
- **PHPMyAdmin**: http://localhost:8080
  - Username: `root`
  - Password: `root`
  - Server: `db`

## Common Docker Commands

### View Running Containers

```bash
docker-compose ps
```

### View Logs

```bash
# All services
docker-compose logs

# Specific service
docker-compose logs app
docker-compose logs webserver
docker-compose logs db
```

### Execute Commands in Containers

```bash
# PHP Artisan commands
docker-compose exec app php artisan {command}

# Composer commands
docker-compose exec app composer {command}

# NPM commands
docker-compose exec app npm {command}

# Access shell in app container
docker-compose exec app bash
```

### Stop Containers

```bash
# Stop but keep data
docker-compose stop

# Stop and remove containers (keeps volumes)
docker-compose down

# Stop and remove everything including volumes
docker-compose down -v
```

### Restart Services

```bash
docker-compose restart
```

## Development Workflow

### Run Queue Worker

```bash
docker-compose exec app php artisan queue:work
```

### Clear Caches

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Run Tests

```bash
docker-compose exec app php artisan test
```

## Troubleshooting

### Port Already in Use

If ports 8000, 8080, or 3306 are already in use, you can modify them in `docker-compose.yml`:

```yaml
webserver:
  ports:
    - "8001:80"  # Change 8000 to 8001

db:
  ports:
    - "3307:3306"  # Change 3306 to 3307
```

### Permission Issues

```bash
# Fix storage permissions
docker-compose exec app chmod -R 775 storage
docker-compose exec app chmod -R 775 bootstrap/cache
```

### Database Connection Issues

Ensure your `.env` file has:

```env
DB_HOST=db  # Must match the service name in docker-compose.yml
DB_PORT=3306
```

### Rebuild After Changes

```bash
# Force rebuild
docker-compose up -d --build --force-recreate
```

## Services Overview

- **app**: PHP 8.3-FPM application container
- **webserver**: Nginx web server
- **db**: MySQL 8.0 database
- **phpmyadmin**: Database management interface
- **redis**: Redis cache/session store

## Additional Configuration

### PHP Configuration

Edit `docker/php/local.ini` to modify PHP settings.

### Nginx Configuration

Edit `docker/nginx/default.conf` to modify Nginx settings.

### MySQL Data Persistence

Database data is persisted in a Docker volume named `dbdata`. To reset the database:

```bash
docker-compose down -v
docker-compose up -d
```

## Production Considerations

For production deployment:

1. Set `APP_DEBUG=false` in `.env`
2. Set `APP_ENV=production`
3. Use environment-specific `.env` files
4. Configure proper SSL certificates
5. Set up proper database backups
6. Use Docker secrets for sensitive data

## Need Help?

If you encounter issues:

1. Check container logs: `docker-compose logs`
2. Verify all services are running: `docker-compose ps`
3. Ensure `.env` file is properly configured
4. Check Docker daemon is running

