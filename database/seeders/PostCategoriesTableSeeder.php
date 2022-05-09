<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::insert([
            ['name' => 'Berita'],
            ['name' => 'Artikel'],
            ['name' => 'Pengumuman'],
            ['name' => 'Info PPDB'],
         ]);
    }
}
