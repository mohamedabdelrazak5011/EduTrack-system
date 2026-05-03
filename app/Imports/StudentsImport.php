<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // حماية لو فيه صف فاضي
        if (empty($row['name']) && empty($row['parent_phone'])) {
            return null;
        }

        return new Student([
            'name' => $row['name'],
            'parent_phone' => $row['parent_phone'],
            'student_code' => 'STD-' . strtoupper(Str::random(6)),
        ]);
    }
}