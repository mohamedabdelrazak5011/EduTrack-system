<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('student_code')->unique();
            $table->string('phone')->nullable();
            $table->string('parent_phone');

            $table->string('photo')->nullable();
            $table->string('national_id')->nullable();
            $table->string('email')->nullable();
            $table->string('grade')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'national_id',
                'email',
                'grade',
                'birth_date',
                'notes',
                'photo',
            ]);
        });
    }
};