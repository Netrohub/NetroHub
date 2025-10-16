#!/bin/bash
# Script to set up MySQL database for NetroHub
# Run this on your Ubuntu server

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Setting up MySQL database for NetroHub${NC}"
echo "================================================"
echo ""

# Prompt for database details
read -p "Enter database name [netrohub]: " DB_NAME
DB_NAME=${DB_NAME:-netrohub}

read -p "Enter database username [netrohub_user]: " DB_USER
DB_USER=${DB_USER:-netrohub_user}

read -sp "Enter database password: " DB_PASS
echo ""

read -sp "Enter MySQL root password: " MYSQL_ROOT_PASS
echo ""
echo ""

# Create database and user
echo -e "${YELLOW}Creating database and user...${NC}"

mysql -u root -p"$MYSQL_ROOT_PASS" <<MYSQL_SCRIPT
-- Create database
CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user and grant privileges
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;

-- Show databases
SHOW DATABASES;
MYSQL_SCRIPT

if [ $? -eq 0 ]; then
    echo ""
    echo -e "${GREEN}✓ Database setup complete!${NC}"
    echo ""
    echo "Add these to your .env file:"
    echo "================================================"
    echo "DB_CONNECTION=mysql"
    echo "DB_HOST=127.0.0.1"
    echo "DB_PORT=3306"
    echo "DB_DATABASE=${DB_NAME}"
    echo "DB_USERNAME=${DB_USER}"
    echo "DB_PASSWORD=${DB_PASS}"
    echo "================================================"
else
    echo "Error setting up database. Please check your MySQL root password."
    exit 1
fi

