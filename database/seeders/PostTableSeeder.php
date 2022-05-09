<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'post_category_id' => 4,
            'title' => 'Informasi PPDB',
            'content' => '<p>Informasi PPDB</p>',
            'image' => '1.jpg',
         ]);
    }
}
