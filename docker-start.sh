#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Elixer Dashboard - Docker Setup${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}.env file not found. Creating from env.docker.example...${NC}"
    cp env.docker.example .env
    echo -e "${GREEN}.env file created successfully!${NC}"
else
    echo -e "${GREEN}.env file already exists.${NC}"
fi

echo ""
echo -e "${BLUE}Building and starting Docker containers...${NC}"
docker-compose up -d --build

echo ""
echo -e "${BLUE}Waiting for containers to be ready...${NC}"
sleep 10

echo ""
echo -e "${BLUE}Installing PHP dependencies...${NC}"
docker-compose exec -T app composer install --no-interaction

echo ""
echo -e "${BLUE}Installing NPM dependencies...${NC}"
docker-compose exec -T app npm install

echo ""
echo -e "${BLUE}Generating application key...${NC}"
docker-compose exec -T app php artisan key:generate

echo ""
echo -e "${BLUE}Setting storage permissions...${NC}"
docker-compose exec -T app chmod -R 775 storage bootstrap/cache

echo ""
echo -e "${YELLOW}Do you want to run database migrations? (y/n)${NC}"
read -p "Enter choice: " migrate_choice

if [[ $migrate_choice == "y" || $migrate_choice == "Y" ]]; then
    echo -e "${BLUE}Running database migrations...${NC}"
    docker-compose exec -T app php artisan migrate --force
    
    echo ""
    echo -e "${YELLOW}Do you want to seed the database? (y/n)${NC}"
    read -p "Enter choice: " seed_choice
    
    if [[ $seed_choice == "y" || $seed_choice == "Y" ]]; then
        echo -e "${BLUE}Seeding database...${NC}"
        docker-compose exec -T app php artisan db:seed --force
    fi
fi

echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}Setup Complete!${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "Access your application at: ${GREEN}http://localhost:8000${NC}"
echo -e "Access PHPMyAdmin at: ${GREEN}http://localhost:8080${NC}"
echo ""
echo -e "Credentials for PHPMyAdmin:"
echo -e "  Username: ${YELLOW}root${NC}"
echo -e "  Password: ${YELLOW}root${NC}"
echo -e "  Server: ${YELLOW}db${NC}"
echo ""
echo -e "Useful commands:"
echo -e "  View logs: ${BLUE}docker-compose logs -f${NC}"
echo -e "  Stop containers: ${BLUE}docker-compose stop${NC}"
echo -e "  Start containers: ${BLUE}docker-compose start${NC}"
echo -e "  Restart containers: ${BLUE}docker-compose restart${NC}"
echo ""

