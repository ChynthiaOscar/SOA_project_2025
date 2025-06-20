<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetupRestaurantDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restaurant:setup-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the Restaurant Review & Rating Database with tables and sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up Restaurant Review & Rating Database...');

        // Check database connection
        try {
            $this->info('Checking database connection...');
            DB::connection()->getPdo();
            $this->info('Database connection established successfully.');
        } catch (\Exception $e) {
            $this->error('Database connection failed: ' . $e->getMessage());
            return 1;
        }

        // Run migrations
        $this->info('Running migrations...');
        $this->call('migrate:fresh', ['--force' => true]);
        
        // Run seeders
        $this->info('Running seeders...');
        $this->call('db:seed', ['--force' => true]);

        // Summary
        $this->info('Database setup completed successfully!');
        
        $tables = [
            'members',
            'vouchers',
            'menus',
            'orders',
            'order_items',
            'reviews',
            'ratings',
        ];
        
        $this->info('');
        $this->info('Sample data summary:');
        $headers = ['Table', 'Records'];
        $rows = [];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $rows[] = [$table, $count];
            } else {
                $rows[] = [$table, 'Table not found'];
            }
        }
        
        $this->table($headers, $rows);
        
        $this->info('');
        $this->info('You can now start the application.');
        $this->info('   - Laravel App is running on: http://localhost:8000');
        
        return 0;
    }
}
