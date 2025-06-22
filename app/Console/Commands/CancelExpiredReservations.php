<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CancelExpiredReservations extends Command
{
    protected $signature = 'reservations:cancel-expired';
    protected $description = 'Cancel reservations that have exceeded the payment deadline';

    public function handle()
    {
        try {
            $response = Http::post('http://52.5.201.24:8002/admin/auto-cancel-expired');

            if ($response->ok()) {
                $data = $response->json();
                $cancelledCount = $data['cancelled_count'] ?? 0;
                $this->info("Cancelled {$cancelledCount} expired reservations.");
            } else {
                $this->error("Failed to cancel expired reservations: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Cancel expired reservations error: ' . $e->getMessage());
            $this->error("Error cancelling expired reservations: " . $e->getMessage());
        }

        return 0;
    }
}
