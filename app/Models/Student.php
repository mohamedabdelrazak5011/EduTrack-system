<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Attendance;
use App\Models\Center;
use App\Models\Result;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_code',
        'phone',
        'parent_phone',
        'photo',
        'national_id',
        'email',
        'grade',
        'birth_date',
        'notes',
        'center_id',
        'gender',   // ✔️ جديد
        'status',   // ✔️ جديد
    ];

    /**
     * 🏫 المركز
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * 📊 الدرجات
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * 🕒 الحضور
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function getGradeNameAttribute()
    {
        return [


            'prep_1' => 'أولى إعدادي',
            'prep_2' => 'ثانية إعدادي',
            'prep_3' => 'ثالثة إعدادي',

            'sec_1' => 'أولى ثانوي',
            'sec_2' => 'ثانية ثانوي',
            'sec_3' => 'ثالثة ثانوي',
        ][$this->grade] ?? $this->grade;
    }
}