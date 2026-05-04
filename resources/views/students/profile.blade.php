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
        : asset('images/default-student.png') }}" class="rounded-circle shadow" width="140"
                            height="140" style="object-fit: cover;">

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
                                    <strong>🏫 الصف:</strong> {{ $student->grade_name ?? 'غير محدد' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>🏢 المركز:</strong> {{ $student->center->name ?? 'بدون مركز' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📱 رقم الطالب:</strong> {{ $student->phone ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📧 الإيميل:</strong> {{ $student->email ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>⚧ النوع:</strong>
                                    {{ $student->gender == 'male' ? 'ولد' : ($student->gender == 'female' ? 'بنت' : '—') }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📌 الحالة:</strong>
                                    {{ $student->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>🎂 تاريخ الميلاد:</strong> {{ $student->birth_date ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>🆔 الرقم القومي:</strong> {{ $student->national_id ?? '—' }}
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📝 ملاحظات:</strong> {{ $student->notes ?? '—' }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- Results Card --}}
        <div class="card shadow mt-4 border-0">

            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span>📊 الدرجات</span>

                <a href="{{ route('results.create', $student->id) }}" class="btn btn-success btn-sm">
                    ➕ إضافة درجة
                </a>
            </div>

            <div class="card-body">

                @if ($student->results->count())

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">

                            <thead class="table-light">
                                <tr>
                                    <th>المادة</th>
                                    <th>الدرجة</th>
                                    <th>من</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($student->results as $result)
                                    <tr>

                                        <td>{{ $result->subject }}</td>
                                        <td>{{ $result->score }}</td>
                                        <td>{{ $result->max_score }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($result->result_date)->format('Y-m-d') }}
                                        </td>

                                        <td>
                                            <form method="POST" action="{{ route('results.destroy', $result->id) }}"
                                                onsubmit="return confirmDeleteResult(this);">

                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="password">

                                                <button class="btn btn-sm btn-danger">
                                                    حذف
                                                </button>

                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-3">
                        <span class="badge bg-success">
                            📈 متوسط الدرجات:
                            {{ round($student->results->avg('score'), 2) }}
                        </span>
                    </div>

                @else
                    <div class="alert alert-info text-center">
                        لا توجد درجات مسجلة لهذا الطالب
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function confirmDeleteResult(form) {
            const password = prompt("❗ أدخل الباسورد لحذف الدرجة:");

            if (!password) return false;

            form.querySelector('input[name="password"]').value = password;
            return true;
        }
    </script>
@endpush