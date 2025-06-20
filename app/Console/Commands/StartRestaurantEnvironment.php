<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class StartRestaurantEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restaurant:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Restaurant Review & Rating Environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Restaurant Review & Rating Environment...');

        // Check if the application key exists
        if (empty(env('APP_KEY'))) {
            $this->info('Generating application key...');
            Artisan::call('key:generate');
            $this->info('Application key generated successfully.');
        }

        // Check if the database is set up
        $this->info('Checking database setup...');
        Artisan::call('restaurant:setup-db');
        $this->info(Artisan::output());

        $this->info('');
        $this->info('Environment setup completed!');
        $this->info('');
        $this->info('Next steps:');
        $this->info('1. Make sure you have RabbitMQ running');
        $this->info('2. Make sure you have Nameko services running on port 8000');
        $this->info('   Command: nameko run backend.review_rating_service backend.http_gateway --config config.yaml');
        $this->info('3. Run the Laravel development server:');
        $this->info('   php artisan serve'); 
        $this->info('');
        $this->info('4. Access the application at: http://localhost:8000');
        
        return 0;
    }
}
