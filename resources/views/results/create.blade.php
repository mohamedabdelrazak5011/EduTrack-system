@extends('layouts.app')

@section('title', 'إضافة درجة')

@section('content')

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                ➕ إضافة درجة للطالب
            </div>

            <div class="card-body">

                <h5 class="mb-3">
                    👨‍🎓 {{ $student->name }}
                </h5>

                <form method="POST" action="{{ route('results.store') }}">
                    @csrf

                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="mb-3">
                        <label>📘 المادة</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>📊 الدرجة</label>
                        <input type="number" name="score" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>🎯 الدرجة النهائية</label>
                        <input type="number" name="max_score" class="form-control" value="100">
                    </div>

                    <button class="btn btn-success">
                        💾 حفظ
                    </button>

                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                        رجوع
                    </a>
                    
                  

                </form>

            </div>

        </div>

    </div>

@endsection