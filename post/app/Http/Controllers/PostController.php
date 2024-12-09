<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post; // Import model Post

class PostController extends Controller
{
    // Phương thức index để lấy danh sách bài viết
    public function index()
    {
        // Lấy tất cả bài viết từ cơ sở dữ liệu
        $posts = Post::all();

        // Trả về view và truyền danh sách bài viết
        return view('posts.index', compact('posts'));
    }
}
