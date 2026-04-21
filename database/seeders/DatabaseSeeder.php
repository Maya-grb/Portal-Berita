<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\News;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'Teknologi'
        ]);

        News::create([
            'title' => 'Berita Teknologi Terbaru',
            'slug' => 'berita-teknologi-terbaru',
            'content' => 'Ini adalah berita teknologi...',
            'image' => 'news1.jpg',
            'user_id' => $admin->id,
            'category_id' => $category->id
        ]);
    }
}