<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function create(Student $student)
    {
        return view('results.create', compact('student'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string',
            'score' => 'required|integer|min:0',
            'max_score' => 'nullable|integer|min:1',
        ]);

        Result::create([
            'student_id' => $request->student_id,
            'subject' => $request->subject,
            'score' => $request->score,
            'max_score' => $request->max_score ?? 100,
            'result_date' => now()->toDateString(),
        ]);

        return redirect()
            ->route('students.show', $request->student_id)
            ->with('success', '✅ تم إضافة الدرجة بنجاح');
    }

    public function index()
    {
        $results = Result::with('student')->latest()->get();

        return view('results.index', compact('results'));
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return back()->with('success', 'تم حذف الدرجة');
    }
}