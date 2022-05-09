<?php

use App\Models\Post as ModelsPost;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      ModelsPost::create([
         'post_category_id' => 4,
         'title' => 'Informasi PPDB',
         'content' => '<p>Informasi PPDB</p>',
         'image' => '1.jpg',
      ]);
   }
}
