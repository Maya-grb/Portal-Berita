<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data berita utama
        $news = News::with('category')->latest()->paginate(5);

        // Ambil berita terbaru untuk sidebar
        $latestNews = News::with('category')->latest()->take(4)->get();

        // Ambil semua kategori
        $categories = Category::all();

        return view('welcome', compact('news', 'latestNews', 'categories'));
    }
}
