# Running Multiple Laravel Projects with Docker

Complete guide for managing multiple Laravel projects efficiently with Docker.

---

## 📋 Table of Contents

1. [Understanding the Requirements](#understanding-the-requirements)
2. [Approach 1: Separate Docker Setup (Recommended)](#approach-1-separate-docker-setup-recommended)
3. [Approach 2: Shared Services with Multiple Apps](#approach-2-shared-services-with-multiple-apps)
4. [Running Multiple Projects](#running-multiple-projects)
5. [Using Custom Domain Names](#using-custom-domain-names)
6. [Shared PHPMyAdmin Setup](#shared-phpmyadmin-setup)

---

## 🎯 Understanding the Requirements

### Questions Answered:

1. **Do you need a Dockerfile for each Laravel project?**
   - ✅ YES (Recommended) - Each project should have its own Dockerfile
   - This ensures isolation and version independence

2. **Do you need PHPMyAdmin for each project?**
   - ❌ NO - You can share one PHPMyAdmin instance
   - PHPMyAdmin can connect to multiple databases

3. **Can you run 2 or more systems together?**
   - ✅ YES - Use different ports or custom domains

4. **Can you run using custom domains?**
   - ✅ YES - Using /etc/hosts and reverse proxy

---

## 🏗️ Approach 1: Separate Docker Setup (Recommended)

This is the simplest and most reliable approach for 10 Laravel projects.

### Structure

```
~/projects/
├── project-1/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── .env
│   └── ...
├── project-2/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── .env
│   └── ...
└── ...
```

### Why This is Best?

- ✅ Each project is independent
- ✅ Easy to manage and debug
- ✅ No port conflicts
- ✅ Can use different PHP versions per project
- ✅ Easy to start/stop individual projects

### Port Allocation Strategy

Assign unique ports to each project:

| Project | Web Port | MySQL Port | Redis Port | PHPMyAdmin Port |
|---------|----------|------------|------------|-----------------|
| Project 1 | 8001 | 3307 | 6380 | 8081 |
| Project 2 | 8002 | 3308 | 6381 | 8082 |
| Project 3 | 8003 | 3309 | 6382 | 8083 |
| ... | ... | ... | ... | ... |

### Example: Project 2 Configuration

**docker-compose.yml** for Project 2:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: project2_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - project2-network

  webserver:
    image: nginx:alpine
    container_name: project2_webserver
    restart: unless-stopped
    ports:
      - "8002:80"  # Different port for each project
    volumes:
      - ./:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - project2-network

  db:
    image: mysql:8.0
    container_name: project2_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: project2_db
      MYSQL_ROOT_PASSWORD: root
      MYSQL_PASSWORD: root
    volumes:
      - project2_dbdata:/var/lib/mysql/
    ports:
      - "3308:3306"  # Different port
    networks:
      - project2-network

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: project2_phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      PMA_USER: root
      PMA_PASSWORD: root
    ports:
      - "8082:80"  # Different port
    networks:
      - project2-network
    depends_on:
      - db

networks:
  project2-network:
    driver: bridge

volumes:
  project2_dbdata:
    driver: local
```

**Access URLs:**
- Web: http://localhost:8002
- PHPMyAdmin: http://localhost:8082

---

## 🔗 Approach 2: Shared Services with Multiple Apps

This approach shares MySQL, Redis, and PHPMyAdmin across multiple projects.

### When to Use This?

- When you want to save resources
- When all projects use the same database version
- When databases can coexist on one MySQL server

### Shared docker-compose.yml

```yaml
version: '3.8'

services:
  # Shared MySQL
  db:
    image: mysql:8.0
    container_name: shared_db
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_PASSWORD: root
    volumes:
      - shared_dbdata:/var/lib/mysql/
    ports:
      - "3306:3306"
    networks:
      - shared-network

  # Shared PHPMyAdmin
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: shared_phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      PMA_USER: root
      PMA_PASSWORD: root
    ports:
      - "8080:80"
    networks:
      - shared-network
    depends_on:
      - db

  # Shared Redis
  redis:
    image: redis:alpine
    container_name: shared_redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    networks:
      - shared-network

  # Project 1
  app1:
    build:
      context: ./project1
      dockerfile: Dockerfile
    container_name: project1_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./project1:/var/www
    networks:
      - shared-network
    depends_on:
      - db
      - redis

  webserver1:
    image: nginx:alpine
    container_name: project1_webserver
    restart: unless-stopped
    ports:
      - "8001:80"
    volumes:
      - ./project1:/var/www
      - ./project1/docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - shared-network
    depends_on:
      - app1

  # Project 2
  app2:
    build:
      context: ./project2
      dockerfile: Dockerfile
    container_name: project2_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./project2:/var/www
    networks:
      - shared-network
    depends_on:
      - db
      - redis

  webserver2:
    image: nginx:alpine
    container_name: project2_webserver
    restart: unless-stopped
    ports:
      - "8002:80"
    volumes:
      - ./project2:/var/www
      - ./project2/docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - shared-network
    depends_on:
      - app2

networks:
  shared-network:
    driver: bridge

volumes:
  shared_dbdata:
    driver: local
```

### Environment Configuration

Each project's `.env` should point to shared services:

**Project 1 `.env`:**
```env
DB_HOST=db           # Shared DB service
DB_DATABASE=project1_db
REDIS_HOST=redis     # Shared Redis
```

**Project 2 `.env`:**
```env
DB_HOST=db           # Shared DB service
DB_DATABASE=project2_db
REDIS_HOST=redis     # Shared Redis
```

---

## 🌐 Using Custom Domain Names

You can access projects using custom domains instead of localhost with ports.

### Method 1: /etc/hosts + Direct Port Access

#### Step 1: Edit /etc/hosts

```bash
sudo nano /etc/hosts
```

Add these lines:
```
127.0.0.1 project1.local
127.0.0.1 project2.local
127.0.0.1 project3.local
127.0.0.1 phpmyadmin.local
```

#### Step 2: Use Different Nginx Configurations

**Project 1 - docker/nginx/default.conf:**
```nginx
server {
    listen 8001;
    server_name project1.local;
    index index.php index.html;
    root /var/www/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**Project 2 - docker/nginx/default.conf:**
```nginx
server {
    listen 8002;
    server_name project2.local;
    ...
}
```

**Access:**
- Project 1: http://project1.local:8001
- Project 2: http://project2.local:8002

### Method 2: Nginx Reverse Proxy (Port 80 Only)

Use Traefik or a reverse proxy to route based on domain names.

**docker-compose.yml with Traefik:**
```yaml
version: '3.8'

services:
  traefik:
    image: traefik:v2.9
    command:
      - "--api.insecure=true"
      - "--providers.docker=true"
      - "--providers.docker.exposedbydefault=false"
      - "--entrypoints.web.address=:80"
    ports:
      - "80:80"
      - "8080:8080"  # Traefik dashboard
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
    networks:
      - shared-network

  app1:
    build: ./project1
    container_name: project1_app
    networks:
      - shared-network
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.project1.rule=Host(`project1.local`)"
      - "traefik.http.services.project1.loadbalancer.server.port=80"

  app2:
    build: ./project2
    container_name: project2_app
    networks:
      - shared-network
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.project2.rule=Host(`project2.local`)"
      - "traefik.http.services.project2.loadbalancer.server.port=80"
```

**Access:**
- Project 1: http://project1.local
- Project 2: http://project2.local
- Traefik Dashboard: http://localhost:8080

---

## 🗄️ Shared PHPMyAdmin Setup

Instead of having one PHPMyAdmin per project, use ONE shared instance.

### Option 1: Separate PHPMyAdmin Container

```yaml
services:
  shared_phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: shared_phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      PMA_USER: root
      PMA_PASSWORD: root
      # Allow connection to multiple servers
      PMA_ABSOLUTE_URI: http://phpmyadmin.local
    ports:
      - "8080:80"
    networks:
      - shared-network
```

Access all databases from one interface: http://localhost:8080

### Option 2: Run Multiple Databases in One MySQL

Each project creates its own database in a shared MySQL instance:

```yaml
services:
  shared_db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      # You can create multiple databases here or let each project create its own
    volumes:
      - shared_dbdata:/var/lib/mysql/
```

Connect from PHPMyAdmin to see all databases.

---

## 📝 Recommended Setup for 10 Projects

### Structure

```
~/projects/
├── docker/
│   ├── nginx/
│   │   ├── project1.conf
│   │   ├── project2.conf
│   │   └── ...
│   └── shared-services.yml
├── project1/
├── project2/
├── project3/
└── ...
```

### Shared Services Compose File

**docker/shared-services.yml:**
```yaml
version: '3.8'

services:
  # Shared MySQL - Multiple Databases
  db:
    image: mysql:8.0
    container_name: shared_mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root
    volumes:
      - shared_dbdata:/var/lib/mysql/
    ports:
      - "3306:3306"
    networks:
      - main-network

  # Shared PHPMyAdmin
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: shared_phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: root
    ports:
      - "8080:80"
    networks:
      - main-network

  # Shared Redis
  redis:
    image: redis:alpine
    container_name: shared_redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    networks:
      - main-network

networks:
  main-network:
    driver: bridge

volumes:
  shared_dbdata:
    driver: local
```

Start shared services:
```bash
docker-compose -f docker/shared-services.yml up -d
```

### Individual Project Compose Files

Each project has its own `docker-compose.yml`:

**project1/docker-compose.yml:**
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: p1_app
    volumes:
      - ./:/var/www
    networks:
      - main-network
    external: true  # Use external network

  webserver:
    image: nginx:alpine
    container_name: p1_webserver
    ports:
      - "8001:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - main-network
    external: true

networks:
  main-network:
    external: true  # Connect to shared network
```

**project2/docker-compose.yml:**
```yaml
# Same structure but ports 8002:80
```

---

## 🚀 Quick Start Script for Multiple Projects

Create a helper script to manage all projects:

**manage-projects.sh:**
```bash
#!/bin/bash

PROJECTS=("project1" "project2" "project3" "project4" "project5")

function start_all() {
    echo "Starting shared services..."
    docker-compose -f docker/shared-services.yml up -d
    
    echo "Starting all projects..."
    for project in "${PROJECTS[@]}"; do
        echo "Starting $project..."
        cd "$project" && docker-compose up -d && cd ..
    done
}

function stop_all() {
    echo "Stopping all projects..."
    for project in "${PROJECTS[@]}"; do
        echo "Stopping $project..."
        cd "$project" && docker-compose down && cd ..
    done
    
    echo "Stopping shared services..."
    docker-compose -f docker/shared-services.yml down
}

function status_all() {
    docker-compose -f docker/shared-services.yml ps
    for project in "${PROJECTS[@]}"; do
        echo "=== $project ==="
        cd "$project" && docker-compose ps && cd ..
    done
}

case "$1" in
    start)
        start_all
        ;;
    stop)
        stop_all
        ;;
    status)
        status_all
        ;;
    *)
        echo "Usage: $0 {start|stop|status}"
        exit 1
        ;;
esac
```

Make it executable and use:
```bash
chmod +x manage-projects.sh
./manage-projects.sh start
./manage-projects.sh stop
./manage-projects.sh status
```

---

## 📊 Port Allocation Reference

For 10 projects, here's a safe port allocation:

| Service | Ports | Purpose |
|---------|-------|---------|
| Web Apps | 8001-8010 | Each project web interface |
| MySQL | 3306 (shared) | Shared database or 3307-3316 for separate |
| PHPMyAdmin | 8080 (shared) | Shared database management |
| Redis | 6379 (shared) | Shared cache/sessions |

---

## ✅ Summary

### Best Practices for Multiple Projects:

1. ✅ **Each project gets its own Dockerfile** - Ensures version independence
2. ✅ **Share PHPMyAdmin** - One instance for all projects
3. ✅ **Use different ports** - Avoid conflicts
4. ✅ **Use custom domains** - Better developer experience
5. ✅ **Optional: Share MySQL** - Save resources if possible
6. ✅ **Optional: Share Redis** - Save resources if possible

### Recommended Approach:

For **10 Laravel projects**, use:
- **Option A:** 10 separate docker-compose setups with unique ports
- **Option B:** 1 shared MySQL + Redis + PHPMyAdmin, 10 separate app containers

Both approaches work well. Choose based on your resource constraints and isolation needs.

---

**Happy multi-project development! 🚀**

