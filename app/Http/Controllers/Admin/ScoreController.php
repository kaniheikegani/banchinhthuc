<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\User;

class ScoreController extends Controller
{
    // Hiển thị danh sách điểm
    public function index()
    {
        $students = User::role('student')
            ->where('approved', true)
            ->with(['scores' => function ($q) {
                $q->where('is_approved', true);
            }])
            ->get();

        $pendingScores = Score::where('is_approved', false)->with('student')->get();

        return view('admin.scores.index', compact('students', 'pendingScores'));
    }

    // Lưu hoặc cập nhật điểm (tránh trùng môn + học kỳ)
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'subject'   => 'required|string|max:100',
            'term'      => 'required|string|max:10',
            'oral'      => 'nullable|numeric|min:0|max:10',
            'attitude'  => 'nullable|numeric|min:0|max:10',
            'midterm'   => 'nullable|numeric|min:0|max:10',
            'final'     => 'nullable|numeric|min:0|max:10',
        ]);

        $oral     = $request->oral ?? 0;
        $attitude = $request->attitude ?? 0;
        $midterm  = $request->midterm ?? 0;
        $final    = $request->final ?? 0;

        $average = round(($oral + $attitude + ($midterm * 2) + ($final * 3)) / 7, 1);

        Score::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'subject' => $request->subject,
                'term'    => $request->term,
            ],
            [
                'oral'       => $oral,
                'attitude'   => $attitude,
                'midterm'    => $midterm,
                'final'      => $final,
                'score'      => $average,
                'grade'      => $this->getGrade($average),
                'is_approved'=> true,
            ]
        );

        return back()->with('success', 'Đã lưu điểm thành công!');
    }

    // Cập nhật điểm theo ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject'   => 'required|string|max:100',
            'term'      => 'required|string|max:10',
            'oral'      => 'nullable|numeric|min:0|max:10',
            'attitude'  => 'nullable|numeric|min:0|max:10',
            'midterm'   => 'nullable|numeric|min:0|max:10',
            'final'     => 'nullable|numeric|min:0|max:10',
        ]);

        $score = Score::findOrFail($id);

        $oral     = $request->oral ?? 0;
        $attitude = $request->attitude ?? 0;
        $midterm  = $request->midterm ?? 0;
        $final    = $request->final ?? 0;

        $average = round(($oral + $attitude + ($midterm * 2) + ($final * 3)) / 7, 1);

        $score->update([
            'subject'   => $request->subject,
            'term'      => $request->term,
            'oral'      => $oral,
            'attitude'  => $attitude,
            'midterm'   => $midterm,
            'final'     => $final,
            'score'     => $average,
            'grade'     => $this->getGrade($average),
        ]);

        return back()->with('success', 'Cập nhật điểm thành công!');
    }

    // Xóa điểm
    public function destroy($id)
    {
        Score::findOrFail($id)->delete();
        return back()->with('success', 'Xóa điểm thành công!');
    }

    // Duyệt điểm
    public function approve($id)
    {
        $score = Score::findOrFail($id);

        $oral     = $score->oral ?? 0;
        $attitude = $score->attitude ?? 0;
        $midterm  = $score->midterm ?? 0;
        $final    = $score->final ?? 0;

        $average = round(($oral + $attitude + ($midterm * 2) + ($final * 3)) / 7, 1);

        $score->update([
            'score'      => $average,
            'grade'      => $this->getGrade($average),
            'is_approved'=> true,
        ]);

        return back()->with('success', 'Đã duyệt điểm môn ' . $score->subject);
    }

    private function getGrade($score)
    {
        if ($score >= 8) return 'Giỏi';
        if ($score >= 6.5) return 'Khá';
        if ($score >= 5) return 'Trung bình';
        return 'Yếu';
    }
}