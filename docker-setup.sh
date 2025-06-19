#!/bin/bash
echo "================================================="
echo "SOA Inventory System - Docker Setup Script"
echo "================================================="

echo "Copying .env.docker to .env for Docker environment..."
cp .env.docker .env

echo "Building and starting Docker containers..."
docker-compose up -d --build

echo "Waiting for services to start..."
sleep 30

echo "Running migrations and seeders..."
docker-compose exec laravel php artisan migrate --seed

echo "================================================="
echo "Setup Complete! Your application is now running:"
echo "- Laravel: http://localhost:8080"
echo "- Gateway API: http://localhost:8000"
echo "- RabbitMQ Management: http://localhost:15672 (guest/guest)"
echo "================================================="

echo "To stop the services, run:"
echo "docker-compose down"
echo "================================================="
