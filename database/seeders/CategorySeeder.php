<?php

namespace Dcodegroup\PageBuilder\Database\Seeders;

use Dcodegroup\LaravelAttachments\Models\Category;
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
        $categories = [
            [
                'type' => 'page-builder',
                'name' => 'Desktop',
                'abstract' => 'Desktop',
                'active' => 1,
            ],
            [
                'type' => 'page-builder',
                'name' => 'Mobile',
                'abstract' => 'Mobile',
                'active' => 1,
            ],
        ];

        foreach($categories as $category) {
            Category::query()->firstOrCreate([
                'type' => $category['type'],
                'name' => $category['name'],
            ], [
                'abstract' => $category['abstract'],
                'active' => $category['active'],
            ]);
        }
    }
}