<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCharacteristic;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $smartphones = Category::where('name', 'Смартфоны')->first();
        $laptops = Category::where('name', 'Ноутбуки')->first();
        $tablets = Category::where('name', 'Планшеты')->first();

        // Smartphones
        $this->createSmartphones($smartphones);
        
        // Laptops
        $this->createLaptops($laptops);
        
        // Tablets
        $this->createTablets($tablets);
    }

    private function createSmartphones($category)
    {
        $smartphones = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Новейший флагманский смартфон Apple с чипом A17 Pro, титановым корпусом и улучшенной камерой. Революционные возможности фотографии и видеосъемки.',
                'price' => 129990,
                'main_image_url' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '6.1" Super Retina XDR OLED',
                    'processor' => 'Apple A17 Pro',
                    'ram' => '8 ГБ',
                    'storage' => '128 ГБ',
                    'battery' => '3274 мАч',
                    'os' => 'iOS 17'
                ]
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Премиальный Android-смартфон с S Pen, мощной камерой 200 МП и ярким дисплеем Dynamic AMOLED 2X. Идеален для профессиональной фотографии.',
                'price' => 119990,
                'main_image_url' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '6.8" Dynamic AMOLED 2X',
                    'processor' => 'Snapdragon 8 Gen 3',
                    'ram' => '12 ГБ',
                    'storage' => '256 ГБ',
                    'battery' => '5000 мАч',
                    'os' => 'Android 14'
                ]
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Смартфон с лучшими возможностями ИИ от Google, чистым Android и превосходной камерой с вычислительной фотографией.',
                'price' => 89990,
                'main_image_url' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '6.7" LTPO OLED',
                    'processor' => 'Google Tensor G3',
                    'ram' => '12 ГБ',
                    'storage' => '128 ГБ',
                    'battery' => '5050 мАч',
                    'os' => 'Android 14'
                ]
            ]
        ];

        foreach ($smartphones as $phoneData) {
            $this->createProduct($phoneData, $category);
        }
    }

    private function createLaptops($category)
    {
        $laptops = [
            [
                'name' => 'MacBook Pro 16" M3 Pro',
                'description' => 'Профессиональный ноутбук Apple с чипом M3 Pro, Liquid Retina XDR дисплеем и невероятной производительностью для творческих задач.',
                'price' => 299990,
                'main_image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '16.2" Liquid Retina XDR',
                    'processor' => 'Apple M3 Pro',
                    'ram' => '18 ГБ',
                    'storage' => '512 ГБ SSD',
                    'battery' => 'до 22 часов',
                    'os' => 'macOS Sonoma'
                ]
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Премиальный ультрабук с процессором Intel Core i7, дискретной графикой NVIDIA и потрясающим 4K OLED дисплеем.',
                'price' => 189990,
                'main_image_url' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1484788984921-03950022c9ef?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '15.6" 4K OLED Touch',
                    'processor' => 'Intel Core i7-13700H',
                    'ram' => '16 ГБ',
                    'storage' => '1 ТБ SSD',
                    'battery' => 'до 13 часов',
                    'os' => 'Windows 11 Pro'
                ]
            ],
            [
                'name' => 'ASUS ROG Strix G15',
                'description' => 'Игровой ноутбук с процессором AMD Ryzen 7, видеокартой RTX 4060 и высокочастотным дисплеем для киберспорта.',
                'price' => 139990,
                'main_image_url' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '15.6" FHD 144Hz',
                    'processor' => 'AMD Ryzen 7 7735HS',
                    'ram' => '16 ГБ',
                    'storage' => '512 ГБ SSD',
                    'battery' => 'до 8 часов',
                    'os' => 'Windows 11 Home'
                ]
            ]
        ];

        foreach ($laptops as $laptopData) {
            $this->createProduct($laptopData, $category);
        }
    }

    private function createTablets($category)
    {
        $tablets = [
            [
                'name' => 'iPad Pro 12.9" M2',
                'description' => 'Самый мощный планшет Apple с чипом M2, Liquid Retina XDR дисплеем и поддержкой Apple Pencil 2-го поколения.',
                'price' => 129990,
                'main_image_url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '12.9" Liquid Retina XDR',
                    'processor' => 'Apple M2',
                    'ram' => '8 ГБ',
                    'storage' => '128 ГБ',
                    'battery' => 'до 10 часов',
                    'os' => 'iPadOS 17'
                ]
            ],
            [
                'name' => 'Samsung Galaxy Tab S9+',
                'description' => 'Премиальный Android-планшет с AMOLED дисплеем, S Pen в комплекте и мощным процессором Snapdragon.',
                'price' => 89990,
                'main_image_url' => 'https://images.unsplash.com/photo-1609081219090-a6d81d3085bf?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1609081219090-a6d81d3085bf?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '12.4" Dynamic AMOLED 2X',
                    'processor' => 'Snapdragon 8 Gen 2',
                    'ram' => '12 ГБ',
                    'storage' => '256 ГБ',
                    'battery' => '10090 мАч',
                    'os' => 'Android 13'
                ]
            ],
            [
                'name' => 'Microsoft Surface Pro 9',
                'description' => 'Универсальный планшет-трансформер с Windows 11, процессором Intel Core i5 и съемной клавиатурой.',
                'price' => 119990,
                'main_image_url' => 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=500&h=500&fit=crop',
                'additional_images' => [
                    'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=500&h=500&fit=crop',
                    'https://images.unsplash.com/photo-1585792180666-f7347c490ee2?w=500&h=500&fit=crop'
                ],
                'characteristics' => [
                    'screen' => '13" PixelSense Touch',
                    'processor' => 'Intel Core i5-1235U',
                    'ram' => '8 ГБ',
                    'storage' => '256 ГБ SSD',
                    'battery' => 'до 15.5 часов',
                    'os' => 'Windows 11 Home'
                ]
            ]
        ];

        foreach ($tablets as $tabletData) {
            $this->createProduct($tabletData, $category);
        }
    }

    private function createProduct($productData, $category)
    {
        // Download main image
        $mainImagePath = $this->downloadImage($productData['main_image_url'], 'products');
        
        // Create product
        $product = Product::create([
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
            'category_id' => $category->id,
            'main_image' => $mainImagePath,
        ]);

        // Create characteristics
        if (isset($productData['characteristics'])) {
            ProductCharacteristic::create([
                'product_id' => $product->id,
                'screen' => $productData['characteristics']['screen'] ?? null,
                'processor' => $productData['characteristics']['processor'] ?? null,
                'ram' => $productData['characteristics']['ram'] ?? null,
                'storage' => $productData['characteristics']['storage'] ?? null,
                'battery' => $productData['characteristics']['battery'] ?? null,
                'os' => $productData['characteristics']['os'] ?? null,
            ]);
        }

        // Create additional images
        if (isset($productData['additional_images'])) {
            foreach ($productData['additional_images'] as $imageUrl) {
                $imagePath = $this->downloadImage($imageUrl, 'products');
                if ($imagePath) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }
        }
    }

    /**
     * Download image from URL and save to storage
     */
    private function downloadImage(string $url, string $folder): ?string
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $filename = $folder . '/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            // If download fails, return null
            \Log::warning("Failed to download image: {$url}. Error: " . $e->getMessage());
            return null;
        }
        
        return null;
    }
}
