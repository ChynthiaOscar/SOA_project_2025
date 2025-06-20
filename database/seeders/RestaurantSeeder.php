<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if data already exists
        if (DB::table('members')->count() > 0) {
            echo "Sample data already exists\n";
            return;
        }

        // Insert Members
        $memberIds = DB::table('members')->insert([
            [
                'member_name' => 'John Doe',
                'member_email' => 'john@example.com',
                'member_phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_name' => 'Jane Smith',
                'member_email' => 'jane@example.com',
                'member_phone' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_name' => 'Bob Wilson',
                'member_email' => 'bob@example.com',
                'member_phone' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // Insert Vouchers
        $voucherIds = DB::table('vouchers')->insert([
            [
                'voucher_code' => 'DISCOUNT10',
                'voucher_description' => 'Diskon 10%',
                'voucher_value' => 10,
                'voucher_type' => 'percentage',
                'voucher_minimum_order' => 50000,
                'voucher_usage_limit' => 100,
                'voucher_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'voucher_code' => 'SAVE20K',
                'voucher_description' => 'Hemat 20.000',
                'voucher_value' => 20000,
                'voucher_type' => 'fixed',
                'voucher_minimum_order' => 100000,
                'voucher_usage_limit' => 50,
                'voucher_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // Insert Menus
        DB::table('menus')->insert([
            [
                'menu_name' => 'Nasi Goreng Spesial',
                'menu_description' => 'Nasi goreng dengan telur dan ayam',
                'menu_price' => 45000,
                'menu_category' => 'Main Course',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Ayam Bakar',
                'menu_description' => 'Ayam bakar bumbu kecap',
                'menu_price' => 50000,
                'menu_category' => 'Main Course',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Soto Ayam',
                'menu_description' => 'Soto ayam kuah bening',
                'menu_price' => 35000,
                'menu_category' => 'Main Course',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Bakso Jumbo',
                'menu_description' => 'Bakso jumbo dengan mie',
                'menu_price' => 40000,
                'menu_category' => 'Main Course',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Es Teh Manis',
                'menu_description' => 'Es teh manis segar',
                'menu_price' => 5000,
                'menu_category' => 'Beverage',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Es Jeruk',
                'menu_description' => 'Es jeruk peras segar',
                'menu_price' => 7000,
                'menu_category' => 'Beverage',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'Kerupuk',
                'menu_description' => 'Kerupuk udang',
                'menu_price' => 3000,
                'menu_category' => 'Side Dish',
                'menu_status' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);// Insert Orders
        DB::table('orders')->insert([
            [
                'order_type' => 1,
                'order_totalPayment' => 150000,
                'Member_member_id' => 1,
                'Voucher_voucher_id' => 1,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::create(2024, 1, 15, 10, 30),
                'updated_at' => Carbon::create(2024, 1, 15, 10, 30),
            ],
            [
                'order_type' => 1,
                'order_totalPayment' => 75000,
                'Member_member_id' => 1,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::create(2024, 1, 20, 15, 45),
                'updated_at' => Carbon::create(2024, 1, 20, 15, 45),
            ],
            [
                'order_type' => 2,
                'order_totalPayment' => 95000,
                'Member_member_id' => 2,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::create(2024, 1, 22, 12, 15),
                'updated_at' => Carbon::create(2024, 1, 22, 12, 15),
            ],
            // New unreviewed orders for testing
            [
                'order_type' => 1,
                'order_totalPayment' => 98000,
                'Member_member_id' => 1,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'order_type' => 2,
                'order_totalPayment' => 125000,
                'Member_member_id' => 1,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'order_type' => 1,
                'order_totalPayment' => 85000,
                'Member_member_id' => 2,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_type' => 2,
                'order_totalPayment' => 67000,
                'Member_member_id' => 3,
                'Voucher_voucher_id' => null,
                'Employee_employee_id' => null,
                'EventReservation_event_id' => null,
                'Reservasi_reservasi_id' => null,
                'PaymentMaster_payment_id' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
        ]);

        // Insert Order Items
        DB::table('order_items')->insert([
            // Order 1 items
            [
                'order_id' => 1,
                'menu_id' => 1,
                'quantity' => 2,
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'menu_id' => 2,
                'quantity' => 1,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'menu_id' => 5,
                'quantity' => 2,
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 2 items
            [
                'order_id' => 2,
                'menu_id' => 3,
                'quantity' => 1,
                'price' => 35000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 2,
                'menu_id' => 4,
                'quantity' => 1,
                'price' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 3 items
            [
                'order_id' => 3,
                'menu_id' => 1,
                'quantity' => 1,
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 3,
                'menu_id' => 2,
                'quantity' => 1,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 4 items (unreviewed)
            [
                'order_id' => 4,
                'menu_id' => 2,
                'quantity' => 1,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'menu_id' => 3,
                'quantity' => 1,
                'price' => 35000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 4,
                'menu_id' => 5,
                'quantity' => 2,
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 5 items (unreviewed)
            [
                'order_id' => 5,
                'menu_id' => 1,
                'quantity' => 2,
                'price' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 5,
                'menu_id' => 6,
                'quantity' => 3,
                'price' => 7000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 5,
                'menu_id' => 7,
                'quantity' => 4,
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 6 items (unreviewed)
            [
                'order_id' => 6,
                'menu_id' => 4,
                'quantity' => 2,
                'price' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 6,
                'menu_id' => 6,
                'quantity' => 1,
                'price' => 7000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Order 7 items (unreviewed)
            [
                'order_id' => 7,
                'menu_id' => 2,
                'quantity' => 1,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 7,
                'menu_id' => 7,
                'quantity' => 3,
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 7,
                'menu_id' => 5,
                'quantity' => 2,
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);        
        
        // Insert Reviews
        // DB::table('reviews')->insert([
        //     [
        //         'review_text' => 'Makanannya enak, pelayanannya ramah. Nasi gorengnya mantap!',
        //         'Order_order_id' => 1,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 15, 12, 0),
        //         'updated_at' => Carbon::create(2024, 1, 15, 12, 0),
        //     ],
        //     [
        //         'review_text' => 'Soto ayamnya kurang pedas, tapi overall enak.',
        //         'Order_order_id' => 2,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 20, 16, 30),
        //         'updated_at' => Carbon::create(2024, 1, 20, 16, 30),
        //     ],
        // ]);

        // Insert Ratings
        // DB::table('ratings')->insert([            // Ratings for Order 1
        //     [
        //         'rating' => 5,
        //         'Menu_menu_id' => 1,
        //         'Order_order_id' => 1,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 15, 12, 0),
        //         'updated_at' => Carbon::create(2024, 1, 15, 12, 0),
        //     ],
        //     [
        //         'rating' => 4,
        //         'Menu_menu_id' => 2,
        //         'Order_order_id' => 1,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 15, 12, 0),
        //         'updated_at' => Carbon::create(2024, 1, 15, 12, 0),
        //     ],
        //     [
        //         'rating' => 5,
        //         'Menu_menu_id' => 5,
        //         'Order_order_id' => 1,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 15, 12, 0),
        //         'updated_at' => Carbon::create(2024, 1, 15, 12, 0),
        //     ],
        //       // Ratings for Order 2
        //     [
        //         'rating' => 3,
        //         'Menu_menu_id' => 3,
        //         'Order_order_id' => 2,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 20, 16, 30),
        //         'updated_at' => Carbon::create(2024, 1, 20, 16, 30),
        //     ],
        //     [
        //         'rating' => 4,
        //         'Menu_menu_id' => 4,
        //         'Order_order_id' => 2,
        //         'Member_member_id' => 1,
        //         'created_at' => Carbon::create(2024, 1, 20, 16, 30),
        //         'updated_at' => Carbon::create(2024, 1, 20, 16, 30),
        //     ],
            
        //     // Ratings for Order 3
        //     [
        //         'rating' => 4,
        //         'Menu_menu_id' => 1,
        //         'Order_order_id' => 3,
        //         'Member_member_id' => 2,
        //         'created_at' => Carbon::create(2024, 1, 22, 13, 0),
        //         'updated_at' => Carbon::create(2024, 1, 22, 13, 0),
        //     ],
        //     [
        //         'rating' => 5,
        //         'Menu_menu_id' => 2,
        //         'Order_order_id' => 3,
        //         'Member_member_id' => 2,
        //         'created_at' => Carbon::create(2024, 1, 22, 13, 0),
        //         'updated_at' => Carbon::create(2024, 1, 22, 13, 0),
        //     ],
        // ]);

        // Print Summary
        echo "Sample data inserted successfully\n";
        echo "\nSample data summary:\n";
        echo "Members: " . DB::table('members')->count() . "\n";
        echo "Menus: " . DB::table('menus')->count() . "\n";
        echo "Orders: " . DB::table('orders')->count() . "\n";
        echo "Reviews: " . DB::table('reviews')->count() . "\n";
        echo "Ratings: " . DB::table('ratings')->count() . "\n";
    }
}
