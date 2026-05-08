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
                'image' => 'storage\app\public\products\pulpen.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Settings
        Setting::create(['key' => 'store_name', 'value' => 'Foto Copy Prima Diski']);
        Setting::create(['key' => 'store_phone', 'value' => '+62 812-3456-7890']);
        Setting::create(['key' => 'store_address', 'value' => 'Jl. Raya Pendidikan No. 45, Kecamatan Sukamaju, Kota Jakarta Selatan, 12345']);
    }
}
