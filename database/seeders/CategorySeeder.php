<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Смартфоны',
                'description' => 'Современные смартфоны от ведущих производителей с передовыми технологиями',
                'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Ноутбуки',
                'description' => 'Мощные ноутбуки для работы, учебы и развлечений',
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Планшеты',
                'description' => 'Удобные планшеты для мобильной работы и развлечений',
                'image_url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=300&fit=crop'
            ]
        ];

        foreach ($categories as $categoryData) {
            // Download and save image
            $imagePath = $this->downloadImage($categoryData['image_url'], 'categories');
            
            Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'image' => $imagePath,
            ]);
        }
    }

    /**
     * Download image from URL and save to storage
     */
    private function downloadImage(string $url, string $folder): ?string
    {
        try {
            $response = Http::get($url);
            
            if ($response->successful()) {
                $filename = $folder . '/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            // If download fails, return null
            return null;
        }
        
        return null;
    }
}
