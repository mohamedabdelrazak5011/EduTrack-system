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
                    <div {{ $student->photo
        ? asset(photo)
        : asset('images/default-student.png') }}"
                        class="rounded-circle shadow" width="140" height="140" style="object-fit: cover;">

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

                            <div class="col-md-6 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <strong>📅 تاريخ الإضافة:</strong>
                                    {{ $student->created_at->format('Y-m-d') }}
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
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->results as $result)
                                    <tr>
                                        <td>{{ $result->subject }}</td>
                                        <td>{{ $result->score }}</td>
                                        <td>{{ $result->max_score }}</td>
                                        <td>

                                            <form method="POST" action="{{ route('results.destroy', $result->id) }}"
                                                onsubmit="return confirmDelete(this);">
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

            if (!password) {
                return false;
            }

            form.querySelector('input[name="password"]').value = password;
            return true;
        }
    </script>
@endpush