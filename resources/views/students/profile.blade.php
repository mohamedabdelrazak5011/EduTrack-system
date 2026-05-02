@extends('layouts.app')

@section('title', 'ملف الطالب')

@section('content')

    <div class="container py-4">

        {{-- Top Card --}}
        <div class="card shadow-lg border-0">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">👨‍🎓 ملف الطالب</h4>

                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-light btn-sm">
                    ✏️ تعديل البيانات
                </a>
            </div>

            <div class="card-body">

                <div class="row align-items-center">

                    {{-- الصورة --}}
                    <div class="col-md-3 text-center">
                        <img src="{{ $student->photo
        ? asset('uploads/students/' . $student->photo)
        : asset('images/default-student.png') }}" class="rounded-circle shadow" width="140" height="140"
                            style="object-fit: cover;">

                        <div class="mt-3">
                            <span class="badge bg-success">
                                🆔 {{ $student->student_code }}
                            </span>
                        </div>
                    </div>

                    {{-- البيانات --}}
                    <div class="col-md-9">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📛 الاسم:</strong> {{ $student->name }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📞 ولي الأمر:</strong> {{ $student->parent_phone ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📧 الإيميل:</strong> {{ $student->email ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>🏫 الصف:</strong> {{ $student->grade ?? 'غير محدد' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>🏢 المركز:</strong> {{ $student->center->name ?? 'بدون مركز' }}
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Results Card --}}
        <div class="card shadow mt-4 border-0">

            <div class="card-header bg-dark text-white">
                📊 الدرجات
            </div>

            <div class="card-body">

                <a href="{{ route('results.create', $student->id) }}" class="btn btn-success mb-3">
                    ➕ إضافة درجة
                </a>

                @if($student->results && $student->results->count() > 0)
                    <div class="mb-3">
                        <span class="badge bg-primary">
                            📊 عدد المواد: {{ $student->results->count() }}
                        </span>

                        <span class="badge bg-success">
                            📈 متوسط الدرجات:
                            {{ $student->results->avg('score') ? round($student->results->avg('score'), 2) : 0 }}
                        </span>
                    </div>
                    <table class="table table-striped text-center">

                        <thead class="table-dark">
                            <tr>
                                <th>المادة</th>
                                <th>الدرجة</th>
                                <th>النهائي</th>
                                <th>النسبة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($student->results as $result)

                                <tr>
                                    <td>{{ $result->subject }}</td>

                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $result->score }}
                                        </span>
                                    </td>

                                    <td>{{ $result->max_score ?? 100 }}</td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ $result->percentage }}%
                                        </span>
                                    </td>

                                    <td>
                                        {{ $result->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else
                    <div class="alert alert-warning text-center">
                        لا توجد درجات مسجلة حالياً
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection