<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject',
        'score',
        'max_score',
        'notes',
        'result_date', // 🔥 مهم جدًا

    ];

    /**
     * 👨‍🎓 علاقة الطالب
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 📊 نسبة الدرجة
     */
    public function getPercentageAttribute()
    {
        return $this->max_score
            ? round(($this->score / $this->max_score) * 100, 2)
            : 0;
    }

    /**
     * 📅 تاريخ النتيجة = وقت الإنشاء
     */
  

}