<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSetupController extends Controller
{
    /**
     * Set up the database for the Restaurant Review & Rating System
     */
    public function setupDatabase()
    {
        $output = [];
        $exitCode = 0;

        try {
            // Check database connection
            echo "Checking database connection...\n";
            DB::connection()->getPdo();
            echo "Database connection established successfully.\n\n";

            // Run migrations
            echo "Running migrations...\n";
            Artisan::call('migrate:fresh', ['--force' => true]);
            $output[] = Artisan::output();
            echo "Migrations completed successfully.\n\n";

            // Run seeders
            echo "Running seeders...\n";
            Artisan::call('db:seed', ['--force' => true]);
            $output[] = Artisan::output();
            echo "Database seeding completed successfully.\n\n";

            // Summary
            echo "Database setup completed!\n";
            echo "You can now start using the application.\n";

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            $exitCode = 1;
        }

        return response()->json([
            'success' => $exitCode === 0,
            'output' => $output,
            'message' => $exitCode === 0 ? 'Database setup completed successfully!' : 'Database setup failed!'
        ]);
    }

    /**
     * Check the status of the database tables and data
     */
    public function checkStatus()
    {
        try {
            $tables = [
                'members' => DB::table('members')->count(),
                'vouchers' => DB::table('vouchers')->count(),
                'menus' => DB::table('menus')->count(),
                'orders' => DB::table('orders')->count(),
                'order_items' => DB::table('order_items')->count(),
                'reviews' => DB::table('reviews')->count(),
                'ratings' => DB::table('ratings')->count(),
            ];

            return response()->json([
                'success' => true,
                'tables' => $tables,
                'message' => 'Database status retrieved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
