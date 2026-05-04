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

        // =========================
        // Students
        // =========================
        $students = Student::query()
            ->when($centerId, fn($q) => $q->where('center_id', $centerId))
            ->get();

        $totalStudents = $students->count();

        // =========================
        // Today Attendance
        // =========================
        $todayAttendance = Attendance::whereDate('date', $today)
            ->when($centerId, function ($q) use ($centerId) {
                $q->whereHas('student', fn($s) => $s->where('center_id', $centerId));
            })
            ->get();

        $presentCount = $todayAttendance->count();
        $checkedOutCount = $todayAttendance->whereNotNull('check_out')->count();
        $absentCount = max($totalStudents - $presentCount, 0);

        // =========================
        // Chart (Last 7 days)
        // =========================
        $dates = [];
        $center1Data = [];
        $center2Data = [];

        $period = CarbonPeriod::create(now()->subDays(6), now());

        foreach ($period as $date) {
            $dates[] = $date->format('d M');

            $center1Data[] = Attendance::whereDate('date', $date)
                ->when($centerId, fn($q) => $q->whereHas('student', fn($s) => $s->where('center_id', $centerId)))
                ->count();

            $center2Data[] = $compareCenterId
                ? Attendance::whereDate('date', $date)
                    ->whereHas('student', fn($s) => $s->where('center_id', $compareCenterId))
                    ->count()
                : 0;
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
            'center2Data',
            'centerId',
            'compareCenterId'
        ));
    }
}