<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // URL ảnh từ Cloudinary (sau này có thể lấy từ DB)
        $imageUrl = 'https://res.cloudinary.com/demo/image/upload/v1699999999/truong-kani.jpg';

        return view('welcome', compact('imageUrl'));
    }
}