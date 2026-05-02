<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;
    protected $date;

    public function __construct($from = null, $to = null, $date = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
    }

    public function collection()
    {
        $query = Attendance::with('student');

        // 📅 يوم محدد
        if ($this->date) {
            $query->whereDate('date', $this->date);
        }

        // 📆 فترة
        if ($this->from && $this->to) {
            $query->whereBetween('date', [$this->from, $this->to]);
        }

        return $query->get();
    }

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

    public function map($a): array
    {
        return [
            $a->student->name ?? '',
            $a->student->student_code ?? '',
            $a->check_out ? 'انصرف' : 'حضور',
            $a->check_in ?? '-',
            $a->check_out ?? '-',
            $a->date,
        ];
    }
}