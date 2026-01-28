<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Indomie Goreng Original', 'Indomie Ayam Bawang', 'Kopi Kapal Api Mix', 
            'Teh Pucuk Harum 350ml', 'Aqua Botol 600ml', 'Le Minerale 600ml', 
            'Chitato Sapi Panggang 68g', 'Oreo Vanilla 133g', 'Sari Roti Tawar Kupas', 
            'Ultra Milk Coklat 250ml', 'Beng-Beng Wafer', 'Silverqueen Chunky Bar',
            'Minyak Goreng Bimoli 1L', 'Gula Pasir Gulaku 1kg', 'Telur Ayam (per butir)',
            'Rokok Sampoerna Mild 16', 'Rokok Gudang Garam Filter', 'Sabun Lifebuoy Cair',
            'Shampo Pantene Sachet', 'Pasta Gigi Pepsodent 75g'
        ];

        foreach ($items as $item) {
            // Logika: Harga Modal random 2rb - 50rb
            $cost = rand(20, 500) * 100; 
            
            // Harga Jual: Modal + Margin 10-30%
            $selling = $cost + ($cost * rand(10, 30) / 100);
            
            // Pembulatan harga jual ke kelipatan 500 terdekat (biar rapi)
            $selling = ceil($selling / 500) * 500;

            Product::create([
                'sku' => '899' . rand(1000000000, 9999999999), // Barcode Indonesia
                'name' => $item,
                'cost_price' => $cost,
                'selling_price' => $selling,
                'stock' => rand(10, 100), // Stok awal 10-100
                'image' => null,
            ]);
        }
    }
}