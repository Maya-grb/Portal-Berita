<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category', 'user')->latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required|string',
            'image'       => 'nullable|string',
        ]);

        News::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'content'     => $request->content,
            'image'       => $request->image,
            'user_id'     => auth()->id() ?? 1,
        ]);

        return redirect()->route('news.index')
                         ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required|string',
            'image'       => 'nullable|string',
        ]);

        $image = $news->image; // ✅ Default pakai gambar lama

        // ✅ Jika checkbox hapus gambar dicentang
        if ($request->has('delete_image')) {
            if ($news->image) {
                Storage::disk('public')->delete('news_images/' . $news->image); // ✅ Fix: hapus 'storage/' di depan
            }
            $image = null;
        }

        // ✅ Jika ada gambar baru
        if ($request->image && $request->image !== $news->image) {
            if ($news->image) {
                Storage::disk('public')->delete('news_images/' . $news->image); // ✅ Fix: hapus 'storage/' di depan
            }
            $image = $request->image;
        }

        $news->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'content'     => $request->content,
            'image'       => $image, // ✅ Pakai variabel $image bukan $request->image ?? $news->image
            'user_id'     => auth()->id() ?? 1,
        ]);

        return redirect()->route('news.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete('news_images/' . $news->image);
        }

        $news->delete();

        return redirect()->route('news.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->extension();

            $path = $file->storeAs('news_images', $filename, 'public');

            return response()->json([
                'url'      => Storage::url($path),
                'filename' => $filename
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengupload gambar'
        ], 400);
    }
}