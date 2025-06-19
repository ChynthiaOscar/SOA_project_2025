@echo off
ECHO =================================================
ECHO SOA Inventory System - Docker Setup Script
ECHO =================================================

ECHO Copying .env.docker to .env for Docker environment...
copy .env.docker .env

ECHO Building and starting Docker containers...
docker-compose up -d --build

ECHO Waiting for services to start...
timeout /t 30

ECHO Running migrations and seeders...
docker-compose exec laravel php artisan migrate --seed

ECHO =================================================
ECHO Setup Complete! Your application is now running:
ECHO - Laravel: http://localhost:8080
ECHO - Gateway API: http://localhost:8000
ECHO - RabbitMQ Management: http://localhost:15672 (guest/guest)
ECHO =================================================

ECHO To stop the services, run:
ECHO docker-compose down
ECHO =================================================
