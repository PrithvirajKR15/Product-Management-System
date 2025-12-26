<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    
    public function run(): void
    {
        $menCategory = Category::firstOrCreate(
            ['name' => 'Men'],
            ['status' => 'active']
        );

        $womenCategory = Category::firstOrCreate(
            ['name' => 'Women'],
            ['status' => 'active']
        );

        $kidsCategory = Category::firstOrCreate(
            ['name' => 'Kids'],
            ['status' => 'active']
        );

        $products = [
            [
                'name' => 'Classic White Cotton Shirt',
                'category_id' => $menCategory->id,
                'description' => 'Premium quality white cotton shirt, perfect for formal occasions. Comfortable fit with button-down collar.',
                'price' => 1299.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Large'],
                    ['key' => 'Color', 'value' => 'White'],
                    ['key' => 'Fabric', 'value' => '100% Cotton'],
                    ['key' => 'Fit', 'value' => 'Regular Fit']
                ]
            ],
            [
                'name' => 'Blue Denim Jeans',
                'category_id' => $menCategory->id,
                'description' => 'Stylish blue denim jeans with a comfortable fit. Perfect for casual wear.',
                'price' => 1899.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '32'],
                    ['key' => 'Color', 'value' => 'Blue'],
                    ['key' => 'Fabric', 'value' => 'Denim'],
                    ['key' => 'Fit', 'value' => 'Slim Fit']
                ]
            ],
            [
                'name' => 'Polo T-Shirt - Navy Blue',
                'category_id' => $menCategory->id,
                'description' => 'Comfortable polo t-shirt in navy blue. Made from premium cotton blend.',
                'price' => 799.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Medium'],
                    ['key' => 'Color', 'value' => 'Navy Blue'],
                    ['key' => 'Fabric', 'value' => 'Cotton Blend'],
                    ['key' => 'Style', 'value' => 'Polo']
                ]
            ],
            [
                'name' => 'Black Formal Trousers',
                'category_id' => $menCategory->id,
                'description' => 'Elegant black formal trousers for office wear. Premium quality fabric.',
                'price' => 1499.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '34'],
                    ['key' => 'Color', 'value' => 'Black'],
                    ['key' => 'Fabric', 'value' => 'Polyester Blend'],
                    ['key' => 'Fit', 'value' => 'Straight Fit']
                ]
            ],
            [
                'name' => 'Casual Checkered Shirt',
                'category_id' => $menCategory->id,
                'description' => 'Trendy checkered shirt perfect for casual outings. Comfortable and stylish.',
                'price' => 999.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Large'],
                    ['key' => 'Color', 'value' => 'Red & White Check'],
                    ['key' => 'Fabric', 'value' => 'Cotton'],
                    ['key' => 'Pattern', 'value' => 'Checkered']
                ]
            ],
            [
                'name' => 'Silk Saree - Traditional Red',
                'category_id' => $womenCategory->id,
                'description' => 'Beautiful traditional red silk saree with intricate border design. Perfect for weddings and festivals.',
                'price' => 4999.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '6 Yards'],
                    ['key' => 'Color', 'value' => 'Red'],
                    ['key' => 'Fabric', 'value' => 'Pure Silk'],
                    ['key' => 'Occasion', 'value' => 'Wedding/Festival']
                ]
            ],
            [
                'name' => 'Designer Lehenga - Royal Blue',
                'category_id' => $womenCategory->id,
                'description' => 'Stunning royal blue designer lehenga with heavy embroidery work. Includes blouse and dupatta.',
                'price' => 8999.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Medium'],
                    ['key' => 'Color', 'value' => 'Royal Blue'],
                    ['key' => 'Fabric', 'value' => 'Georgette'],
                    ['key' => 'Work', 'value' => 'Heavy Embroidery']
                ]
            ],
            [
                'name' => 'Cotton Churidar Set - Pink',
                'category_id' => $womenCategory->id,
                'description' => 'Comfortable pink cotton churidar set with kurti and dupatta. Perfect for daily wear.',
                'price' => 1299.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Medium'],
                    ['key' => 'Color', 'value' => 'Pink'],
                    ['key' => 'Fabric', 'value' => 'Cotton'],
                    ['key' => 'Set Includes', 'value' => 'Kurti, Churidar, Dupatta']
                ]
            ],
            [
                'name' => 'Anarkali Suit - Green',
                'category_id' => $womenCategory->id,
                'description' => 'Elegant green anarkali suit with beautiful prints. Perfect for parties and celebrations.',
                'price' => 2499.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Large'],
                    ['key' => 'Color', 'value' => 'Green'],
                    ['key' => 'Fabric', 'value' => 'Chiffon'],
                    ['key' => 'Style', 'value' => 'Anarkali']
                ]
            ],
            [
                'name' => 'Cotton Salwar Kameez - White',
                'category_id' => $womenCategory->id,
                'description' => 'Classic white cotton salwar kameez with elegant embroidery. Comfortable for daily wear.',
                'price' => 1799.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Medium'],
                    ['key' => 'Color', 'value' => 'White'],
                    ['key' => 'Fabric', 'value' => 'Cotton'],
                    ['key' => 'Style', 'value' => 'Salwar Kameez']
                ]
            ],
            [
                'name' => 'Designer Saree - Peach',
                'category_id' => $womenCategory->id,
                'description' => 'Elegant peach colored designer saree with zari work. Perfect for formal occasions.',
                'price' => 3499.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '6 Yards'],
                    ['key' => 'Color', 'value' => 'Peach'],
                    ['key' => 'Fabric', 'value' => 'Silk'],
                    ['key' => 'Work', 'value' => 'Zari Work']
                ]
            ],
            [
                'name' => 'Lehenga Choli - Maroon',
                'category_id' => $womenCategory->id,
                'description' => 'Beautiful maroon lehenga choli with mirror work. Includes blouse and dupatta.',
                'price' => 5999.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => 'Large'],
                    ['key' => 'Color', 'value' => 'Maroon'],
                    ['key' => 'Fabric', 'value' => 'Silk'],
                    ['key' => 'Work', 'value' => 'Mirror Work']
                ]
            ],
            [
                'name' => 'Kids T-Shirt - Cartoon Print',
                'category_id' => $kidsCategory->id,
                'description' => 'Colorful kids t-shirt with fun cartoon prints. Made from soft cotton for comfort.',
                'price' => 399.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '6-8 Years'],
                    ['key' => 'Color', 'value' => 'Multi Color'],
                    ['key' => 'Fabric', 'value' => 'Cotton'],
                    ['key' => 'Print', 'value' => 'Cartoon']
                ]
            ],
            [
                'name' => 'Kids Denim Jeans',
                'category_id' => $kidsCategory->id,
                'description' => 'Durable kids denim jeans with adjustable waist. Perfect for active kids.',
                'price' => 699.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '8-10 Years'],
                    ['key' => 'Color', 'value' => 'Blue'],
                    ['key' => 'Fabric', 'value' => 'Denim'],
                    ['key' => 'Feature', 'value' => 'Adjustable Waist']
                ]
            ],
            [
                'name' => 'Girls Frock - Pink',
                'category_id' => $kidsCategory->id,
                'description' => 'Beautiful pink frock for little girls with floral prints. Perfect for parties.',
                'price' => 899.00,
                'status' => 'active',
                'attributes' => [
                    ['key' => 'Size', 'value' => '4-6 Years'],
                    ['key' => 'Color', 'value' => 'Pink'],
                    ['key' => 'Fabric', 'value' => 'Cotton'],
                    ['key' => 'Style', 'value' => 'Frock']
                ]
            ],
        ];
        foreach ($products as $productData) {
            $attributes = $productData['attributes'];
            unset($productData['attributes']);

            $productData['image'] = 'products/placeholder.jpg';
            $product = Product::create($productData);

            foreach ($attributes as $attribute) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => $attribute['key'],
                    'attribute_value' => $attribute['value'],
                ]);
            }
        }
        $this->command->info('15 products with attributes created successfully!');
    }
}
