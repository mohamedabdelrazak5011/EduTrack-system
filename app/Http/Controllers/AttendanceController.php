<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * 📊 عرض الحضور (يوم + فترة)
     */
    public function index(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $from = $request->from;
        $to = $request->to;

        $students = Student::all();

        $query = Attendance::query();

        // 🟡 فلترة يوم
        if ($request->date) {
            $query->whereDate('date', $date);
        }

        // 🟡 فلترة فترة
        if ($from && $to) {
            $query->whereBetween('date', [$from, $to]);
        }

        $attendance = $query->get()->keyBy('student_id');

        $presentCount = $attendance->whereNotNull('check_in')->count();
        $absentCount = $students->count() - $presentCount;

        return view('attendance.index', compact(
            'students',
            'attendance',
            'date',
            'from',
            'to',
            'presentCount',
            'absentCount'
        ));
    }

    /**
     * 📥 Export Excel (يوم أو فترة)
     */
    public function export(Request $request)
    {
        return Excel::download(
            new AttendanceExport(
                $request->from,
                $request->to,
                $request->date
            ),
            'attendance.xlsx'
        );
    }

    /**
     * 📟 Scan page
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
            return response()->json(['message' => '❌ كود غير صحيح', 'type' => 'error']);
        }

        $student = Student::where('student_code', $code)->first();

        if (!$student) {
            return response()->json(['message' => '❌ الطالب غير موجود', 'type' => 'error']);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        // Check-in
        if (!$attendance) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'check_in' => now(),
            ]);

            return response()->json([
                'message' => '✅ تم تسجيل الحضور',
                'type' => 'checkin',
                'student' => $student
            ]);
        }

        // Check-out
        if (!$attendance->check_out) {
            $attendance->update([
                'check_out' => now(),
            ]);

            return response()->json([
                'message' => '✅ تم تسجيل الانصراف',
                'type' => 'checkout',
                'student' => $student
            ]);
        }

        return response()->json([
            'message' => 'ℹ️ تم تسجيل اليوم بالفعل',
            'type' => 'done',
            'student' => $student
        ]);
    }
}