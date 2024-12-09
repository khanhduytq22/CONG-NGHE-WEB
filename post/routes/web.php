<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index']); // Route hiển thị trang chủ
Route::get('posts', [PostController::class, 'index']); // Route hiển thị danh sách bài viết
