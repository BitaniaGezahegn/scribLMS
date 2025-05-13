#!/bin/bash
set -e

# Make script executable
chmod +x .devcontainer/postCreate.sh

# Install MySQL
apt-get update
apt-get install -y mysql-server

# Start MySQL service
service mysql start

# Configure Apache to use port 8080
sed -i 's/Listen 80$/Listen 8080/' /etc/apache2/ports.conf
sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-enabled/000-default.conf

# Set document root to workspace
sed -i 's|/var/www/html|/workspaces/'$(basename $PWD)'|g' /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
a2enmod rewrite

# Restart Apache
service apache2 restart

# Create database and import schema
mysql -e "CREATE DATABASE locallibrary;"
mysql -e "CREATE USER 'root'@'localhost' IDENTIFIED BY '';"
mysql -e "GRANT ALL PRIVILEGES ON locallibrary.* TO 'root'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# Import database schema if SQL file exists
if [ -f "Assets/SQL/Create.sql" ]; then
    mysql locallibrary < Assets/SQL/Create.sql
fi