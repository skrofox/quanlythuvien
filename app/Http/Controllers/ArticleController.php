<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('categories', 'user')
            ->where('status', 'published')
            ->orderByDesc('created_at');

        // Tìm kiếm theo từ khóa
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('summary', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.slug', $request->category);
            });
        }

        $articles = $query->paginate(12);
        $categories = Category::whereHas('posts', function($q) {
            $q->where('status', 'published');
        })->get();

        return view('frontend.articles', compact('articles', 'categories'));
    }
}
