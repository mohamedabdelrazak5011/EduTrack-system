<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            // ربط النتيجة بالطالب
            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            // بيانات النتيجة
            $table->string('subject');      // اسم المادة
            $table->integer('score');       // الدرجة
            $table->integer('max_score')->default(100); // الدرجة النهائية
            $table->date('result_date');    // تاريخ النتيجة
            $table->text('notes')->nullable(); // ملاحظات

            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
};