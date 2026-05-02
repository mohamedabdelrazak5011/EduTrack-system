<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Attendance::with('student')
            ->whereDate('date', now()->toDateString())
            ->get();
    }

    public function headings(): array
    {
        return [
            'اسم الطالب',
            'كود الطالب',
            'الحالة',
            'وقت الحضور',
            'وقت الانصراف',
            'التاريخ',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->student->name,
            $attendance->student->student_code,
            $attendance->check_out ? 'انصراف' : 'حضور',
            optional($attendance->check_in)->format('H:i'),
            optional($attendance->check_out)->format('H:i'),
            $attendance->date->format('Y-m-d'),
        ];
    }
}