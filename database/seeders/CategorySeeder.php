<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Peralatan elektronik',
            ],
            [
                'name' => 'Alat Tulis',
                'description' => 'Perlengkapan alat tulis',
            ],
            [
                'name' => 'Perlengkapan Kantor',
                'description' => 'Barang kebutuhan kantor',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
