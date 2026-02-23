<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image_url' => 'nullable|url',
            'category' => 'required|in:general,competition',
        ]);

        News::create($request->only('title', 'content', 'image_url'));

        return redirect()->route('admin.news')->with('success', 'Đã thêm tin tức mới!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image_url' => 'nullable|url',
        ]);

        $news = News::findOrFail($id);
        $news->update($request->only('title', 'content', 'image_url'));

        return redirect()->route('admin.news')->with('success', 'Đã cập nhật tin tức!');
    }

    public function destroy($id)
    {
        News::destroy($id);
        return back()->with('success', 'Đã xóa tin tức!');
    }
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }
    public function showForStudent($id)
    {
        $news = News::findOrFail($id);
        return view('student.news.show', compact('news'));
    }

    public function showForTeacher($id)
    {
        $news = News::findOrFail($id);
        return view('teacher.news.show', compact('news'));
    }
}