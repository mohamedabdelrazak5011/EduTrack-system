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
        'parent_phone',
        'photo',
        'national_id',
        'email',
        'grade',
        'birth_date',
        'notes',
        'center_id', // 🔥 مهم جدًا
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
}