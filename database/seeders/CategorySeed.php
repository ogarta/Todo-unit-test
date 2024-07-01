<?php

namespace Database\Seeders;

use App\Enums\CategoriesEnum;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect(CategoriesEnum::cases())
            ->map(fn($category) => ['name' => $category->value])
            ->toArray();
        foreach ($data as $category) {
            Category::withoutEvents(function () use ($category) {
                Category::updateOrCreate([
                    'name' => $category['name'],
                    'user_id' => 1,
                ]);
            });
        }
    }
}
