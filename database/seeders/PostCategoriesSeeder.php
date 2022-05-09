<?php

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategoriesSeeder extends Seeder
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
