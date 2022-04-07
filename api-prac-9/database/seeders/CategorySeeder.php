<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Man',
            'slug' => 'man'
        ]);
        Category::create([
            'name' => 'Woman',
            'slug' => 'woman'
        ]);
        Category::create([
            'name' => 'Kid',
            'slug' => 'kid'
        ]);
    }
}
