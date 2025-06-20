# Restaurant Review & Rating System

A Laravel application for restaurant reviews and ratings, connected to a Nameko microservice backend.

## Database Setup

This project uses Laravel's migration and seeding system to set up the database. You can choose between MySQL and SQLite databases.

### Option 1: Using the Setup Command

The easiest way to set up the database is using the provided Artisan command:

```bash
# Generate an application key if not already done
php artisan key:generate

# Run the database setup command
php artisan restaurant:setup-db
```

### Option 2: Manual Setup

If you prefer to set up the database manually:

1. Configure your database in the `.env` file (copy from `example.env`)
2. Run the migrations to create the tables:
   ```bash
   php artisan migrate:fresh
   ```
3. Run the seeders to populate sample data:
   ```bash
   php artisan db:seed
   ```

### Option 3: Web Interface

You can also set up the database via a web interface:

1. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
2. Visit `http://localhost:8000/db-setup/setup` in your browser
3. Check the status at `http://localhost:8000/db-setup/status`

## Database Structure

The database for this application contains the following tables:

1. `members` - Store information about restaurant members
2. `vouchers` - Store vouchers that can be used for orders
3. `menus` - Store available menu items
4. `orders` - Store order information
5. `order_items` - Store items within orders
6. `reviews` - Store text reviews for orders
7. `ratings` - Store numeric ratings for menu items

## Sample Data

The database seeders populate the database with sample data including:

- 3 members
- 2 vouchers
- 7 menu items
- 3 orders
- 7 order items
- 2 reviews
- 7 ratings

This allows you to immediately start testing the application without having to create your own data.

## Starting the Application

1. Ensure your database is set up using one of the methods above
2. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
3. Visit `http://localhost:8000` in your browser

## Backend Microservice

This Laravel application is designed to work with a Nameko microservice backend.
Ensure your Nameko service is running as specified in your original `database_setup.py` script:

1. Start RabbitMQ server
2. Run: `nameko run backend.nameko_service --config config.yaml`
3. Run: `python backend/web_service.py`
