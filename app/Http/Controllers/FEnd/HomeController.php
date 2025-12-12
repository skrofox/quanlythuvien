<?php

namespace App\Http\Controllers\FEnd;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $newBooks = Book::with(['images'])->take(4)->orderByDesc('created_at')->get();
        $books = Book::with(['images', 'categories'])->take(12)->orderByDesc('created_at')->get();
        $sliders = Book::with('images')->take(5)->get();
        $posts = Post::with('categories', 'user')->take(3)->orderByDesc('created_at')->get();
        $categories = Category::with(['books' => function ($query) {
            $query->with('images')->take(4)->orderByDesc('created_at');
        }])->inRandomOrder()->take(4)->get();

        return view('frontend.index', compact('newBooks', 'sliders', 'books', 'categories', 'posts'));
    }

    public function quotes()
    {
        $response = Http::get('https://zenquotes.io/api/today');
        return $response->json();
    }

    public function book_detail($slug)
    {
        $book = Book::with(['images', 'categories', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        //lấy sách liên quan theo danh mục, loại trừ sách hiện tại
        $relatedBooks = Book::with(['images', 'categories'])->whereHas('categories', function ($query) use ($book) {
            $query->whereIn('categories.id', $book->categories->pluck('id'));
        })->where('id', '!=', $book->id)->inRandomOrder()->take(4)->get();
        // })->inRandomOrder()->take(4)->get();
        // Calculate average rating
        $avgRating = $book->reviews->avg('rating') ?? 0;
        $ratingCount = $book->reviews->count();

        return view('frontend.book-detail', compact('book', 'avgRating', 'ratingCount', 'relatedBooks'));
    }

    public function post_detail($slug)
    {
        $post = Post::with('categories', 'user')->where('slug', $slug)->firstOrFail();

        // Tăng lượt xem
        $post->increment('views');

        // Lấy bài viết liên quan (cùng danh mục, loại trừ bài viết hiện tại)
        $relatedPosts = Post::with('user')
            ->whereHas('categories', function ($query) use ($post) {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Lấy bài viết cùng chuyên đề (cùng danh mục) để hiển thị cuối trang
        $relatedCategoryPosts = Post::with('user')
            ->whereHas('categories', function ($query) use ($post) {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('frontend.post-detail', compact('post', 'relatedPosts', 'relatedCategoryPosts'));
    }
}
