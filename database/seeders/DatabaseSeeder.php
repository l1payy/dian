<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Prima',
            'email' => 'admin@primadiski.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Sample Products
        $products = [
            [
                'name' => 'Pulpen',
                'description' => 'Pulpen Hitam',
                'price' => 3000,
                'stock' => 100,
                'image' => 'products/pulpen.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Settings
        Setting::create(['key' => 'store_name', 'value' => 'Toko Prima']);
        Setting::create(['key' => 'store_phone', 'value' => '0813-6161-6708']);
        Setting::create(['key' => 'store_address', 'value' => 'Jl. Sei Mencirim No.122, Medan Krio, Kec. Sunggal, Kabupaten Deli Serdang, Sumatera Utara']);
    }
}
