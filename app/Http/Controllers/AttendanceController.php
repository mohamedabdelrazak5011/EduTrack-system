<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * 📊 عرض الحضور مع اختيار يوم
     */
    public function index(Request $request)
    {
        $date = $request->get('date')
            ? Carbon::parse($request->get('date'))
            : Carbon::today();

        $students = Student::all();

        $attendance = Attendance::whereDate('date', $date->format('Y-m-d'))
            ->get()
            ->keyBy('student_id');

        $presentCount = $attendance->count();
        $absentCount = $students->count() - $presentCount;

        return view('attendance.index', compact(
            'students',
            'attendance',
            'date',
            'presentCount',
            'absentCount'
        ));
    }

    /**
     * 📟 صفحة الاسكان
     */
    public function scan()
    {
        return view('attendance.scan');
    }

    /**
     * 🟢 تسجيل حضور / انصراف
     */
    public function store(Request $request)
    {
        $code = trim($request->code);

        if (!$code) {
            return response()->json([
                'message' => '❌ كود غير صحيح',
                'type' => 'error'
            ]);
        }

        $student = Student::where('student_code', $code)->first();

        if (!$student) {
            return response()->json([
                'message' => '❌ الطالب غير موجود',
                'type' => 'error'
            ]);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        // 🟢 Check-in
        if (!$attendance) {

            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_in' => now(),
            ]);

            return response()->json([
                'message' => '✅ تم تسجيل الحضور',
                'type' => 'checkin',

                // ⭐ مهم جدًا للـ popup
                'student' => [
                    'name' => $student->name,
                    'photo' => $student->photo
                ]
            ]);
        }

        // 🟡 Check-out
        if (!$attendance->check_out) {

            $attendance->update([
                'check_out' => now(),
            ]);

            return response()->json([
                'message' => '✅ تم تسجيل الانصراف',
                'type' => 'checkout',

                // ⭐ مهم جدًا للـ popup
                'student' => [
                    'name' => $student->name,
                    'photo' => $student->photo
                ]
            ]);
        }

        // 🔵 Done
        return response()->json([
            'message' => 'ℹ️ تم تسجيل الحضور والانصراف بالفعل اليوم',
            'type' => 'done',

            'student' => [
                'name' => $student->name,
                'photo' => $student->photo
            ]
        ]);
    }
}