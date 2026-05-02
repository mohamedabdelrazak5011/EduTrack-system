<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Center;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $centers = Center::all();

        $centerId = $request->center_id;
        $compareCenterId = $request->compare_center_id;

        // 🎓 الطلاب
        $studentsQuery = Student::query();

        if ($centerId) {
            $studentsQuery->where('center_id', $centerId);
        }

        $totalStudents = $studentsQuery->count();

        // 📅 حضور اليوم
        $attendanceQuery = Attendance::whereDate('date', $today);

        if ($centerId) {
            $attendanceQuery->whereHas('student', function ($q) use ($centerId) {
                $q->where('center_id', $centerId);
            });
        }

        $attendanceToday = $attendanceQuery->get();

        $presentCount = $attendanceToday->count();

        $checkedOutCount = $attendanceToday->whereNotNull('check_out')->count();

        $absentCount = $totalStudents - $presentCount;

        // 📊 CHART DATA
        $dates = [];
        $center1Data = [];
        $center2Data = [];

        $period = CarbonPeriod::create(now()->subDays(6), now());

        foreach ($period as $date) {

            $dates[] = $date->format('d M');

            // 🟢 Center 1
            $q1 = Attendance::whereDate('date', $date);

            if ($centerId) {
                $q1->whereHas('student', function ($q) use ($centerId) {
                    $q->where('center_id', $centerId);
                });
            }

            $center1Data[] = $q1->count();

            // 🔵 Center 2 (Comparison)
            if ($compareCenterId) {
                $q2 = Attendance::whereDate('date', $date)
                    ->whereHas('student', function ($q) use ($compareCenterId) {
                        $q->where('center_id', $compareCenterId);
                    });

                $center2Data[] = $q2->count();
            }
        }

        return view('dashboard', compact(
            'today',
            'centers',
            'totalStudents',
            'presentCount',
            'checkedOutCount',
            'absentCount',
            'dates',
            'center1Data',
            'center2Data'
        ));
    }
}