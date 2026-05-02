@extends('layouts.app')

@section('title', 'قائمة الطلاب')

@section('content')

    <div class="container">

        {{-- زر إضافة طالب --}}
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">
            ➕ إضافة طالب
        </a>

        {{-- قائمة الطلاب --}}
        @foreach ($students as $student)

            <div class="card mb-3 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">

                    {{-- الصورة + البيانات --}}
                    <div class="d-flex align-items-center gap-4">

                        {{-- صورة الطالب --}}
                        <img src="{{ $student->photo
                ? asset('uploads/students/' . $student->photo)
                : asset('images/default-student.png') }}" width="80" height="80" class="rounded-circle border"
                            style="object-fit: cover;">

                        <div>

                            {{-- الاسم --}}
                            <h5 class="mb-1">{{ $student->name }}</h5>

                            {{-- كود الطالب --}}
                            <span class="badge bg-secondary mb-2">
                                {{ $student->student_code }}
                            </span>

                            {{-- بيانات إضافية --}}
                            <div class="text-muted small mt-2">

                                <div>📞 {{ $student->parent_phone ?? '—' }}</div>

                                <div>📧 {{ $student->email ?? '—' }}</div>

                                {{-- المرحلة / الصف --}}
                                <div>🏫 {{ $student->class ?? 'غير محدد' }}</div>

                                {{-- المركز --}}
                                <div>🏢 {{ $student->center->name ?? 'بدون مركز' }}</div>

                            </div>

                        </div>

                    </div>

                    {{-- الأزرار --}}
                    <div class="d-flex gap-2">

                        <a href="{{ route('students.profile', $student->id) }}" class="btn btn-outline-primary btn-sm">
                            📂 الملف
                        </a>

                        <a href="{{ route('students.qr', $student->id) }}" class="btn btn-outline-warning btn-sm">
                            🔳 QR
                        </a>

                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-secondary btn-sm">
                            ✏️ تعديل
                        </a>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $student->id }}">
                            حذف
                        </button>

                    </div>

                </div>
            </div>

            {{-- Modal الحذف (لازم يكون داخل الـ loop لكن خارج card) --}}
            <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1">
                <div class="modal-dialog">

                    <form method="POST" action="{{ route('students.destroy', $student->id) }}">
                        @csrf
                        @method('DELETE')

                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">تأكيد الحذف</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p>أدخل كلمة المرور لتأكيد الحذف:</p>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">حذف</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        @endforeach

    </div>

@endsection