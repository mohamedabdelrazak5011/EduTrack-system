<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;
    protected $date;

    protected $data;

    public function __construct($from = null, $to = null, $date = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
    }

    /**
     * 🟢 بناء الداتا (كل الطلاب + الحضور/الغياب)
     */
    public function collection()
    {
        $students = Student::all();

        $query = Attendance::with('student');

        // 📅 يوم محدد
        if ($this->date) {
            $query->whereDate('date', $this->date);
        }

        // 📆 فترة
        if ($this->from && $this->to) {
            $query->whereBetween('date', [$this->from, $this->to]);
        }

        $attendances = $query->get()->groupBy('student_id');

        $result = [];

        foreach ($students as $student) {

            // لو الطالب ليه حضور
            if (isset($attendances[$student->id])) {

                foreach ($attendances[$student->id] as $attendance) {
                    $result[] = $attendance;
                }

            } else {

                // ❌ غايب
                $result[] = (object) [
                    'student' => $student,
                    'check_in' => null,
                    'check_out' => null,
                    'date' => $this->date ?? now()->toDateString(),
                ];
            }
        }

        $this->data = collect($result);

        return $this->data;
    }

    /**
     * 📊 Header بتاع Excel
     */
    public function headings(): array
    {
        return [
            'اسم الطالب',
            'كود الطالب',
            'الحالة',
            'الحضور',
            'الانصراف',
            'التاريخ',
        ];
    }

    /**
     * 🧾 شكل كل صف في Excel
     */
    public function map($a): array
    {
        return [
            $a->student->name ?? '',
            $a->student->student_code ?? '',
            $this->getStatus($a),
            $a->check_in ?? '-',
            $a->check_out ?? '-',
            $a->date ?? '',
        ];
    }

    /**
     * 🟢 تحديد الحالة (حضور / انصراف / غياب)
     */
    private function getStatus($a)
    {
        if (!isset($a->student)) {
            return 'غائب';
        }

        if ($a->check_in && $a->check_out) {
            return 'انصرف';
        }

        if ($a->check_in && !$a->check_out) {
            return 'حضور';
        }

        return 'غائب';
    }
}