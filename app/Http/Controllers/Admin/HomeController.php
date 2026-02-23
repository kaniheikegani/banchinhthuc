<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\News;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HomeController extends Controller
{
    public function edit()
    {
        $contents = Setting::pluck('value', 'key')->toArray();
        return view('admin.home.edit', compact('contents'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
        return back()->with('success', 'Đã cập nhật nội dung trang chủ!');
    }

    public function home()
    {
        $contents = Setting::pluck('value', 'key')->toArray();

        $generalNews = News::where('category', 'general')->latest()->take(6)->get();
        $competitionNews = News::where('category', 'competition')->latest()->take(6)->get();

        return view('home', compact('contents', 'generalNews', 'competitionNews'));
    }
}
