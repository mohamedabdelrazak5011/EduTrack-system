@extends('layouts.app')

@section('title', 'قائمة الطلاب')

@section('content')

    {{-- ===== FILTER & ACTIONS ===== --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-center">

                <div class="col-md-6">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="🔍 ابحث باسم الطالب / الكود / رقم الموبايل">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">
                        بحث
                    </button>
                </div>

                <div class="col-md-3 text-end">
                    <a href="{{ route('students.create') }}" class="btn btn-success w-100">
                        ➕ إضافة طالب
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== EXCEL IMPORT ===== --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data"
                class="d-flex gap-3 align-items-center">
                @csrf

                <input type="file" name="file" required class="form-control">

                <button type="submit" class="btn btn-primary">
                    📤 رفع ملف Excel
                </button>
            </form>
        </div>
    </div>

    {{-- ===== STUDENTS CARDS ===== --}}
    <div class="row g-4">

        @forelse($students as $student)

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">

                    {{-- Card Body --}}
                    <div class="card-body d-flex gap-3">
                        <img src="{{ $student->photo
                ? asset('uploads/students/' . $student->photo)
                : asset('uploads/students/default-avatar.png') }}" class="student-avatar" alt="student">

                        {{-- Info --}}
                        <div class="flex-grow-1">

                            <h5 class="mb-1">{{ $student->name }}</h5>

                            <span class="badge bg-secondary mb-2">
                                {{ $student->student_code }}
                            </span>

                            <div class="text-muted small">
                                📞 {{ $student->phone ?? 'غير مسجل' }} <br>
                                🏫 {{ $student->center->name ?? 'غير محدد' }} <br>
                               @php
    $grades = [
        'prep_1' => 'أولى إعدادي',
        'prep_2' => 'ثانية إعدادي',
        'prep_3' => 'ثالثة إعدادي',

        'sec_1' => 'أولى ثانوي',
        'sec_2' => 'ثانية ثانوي',
        'sec_3' => 'ثالثة ثانوي',
    ];
@endphp

📘 {{ $grades[$student->grade] ?? $student->grade }}
                            </div>

                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="card-footer bg-light d-flex gap-2 justify-content-between">

                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary">
                            الملف
                        </a>

                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
                            تعديل
                        </a>

                        <a href="{{ route('students.qr', $student) }}" class="btn btn-sm btn-outline-info">
                            QR
                        </a>

                        <form method="POST" action="{{ route('students.destroy', $student->id) }}"
                            onsubmit="return confirmDelete(this);">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="password">

                            <button class="btn btn-sm btn-danger">
                                حذف
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا يوجد طلاب مطابقين لبحثك
                </div>
            </div>
        @endforelse

    </div>

@endsection
@push('scripts')
    <script>
        function confirmDelete(form) {
            const password = prompt("❗ أدخل الباسورد لحذف الطالب:");

            if (!password) {
                return false; // المستخدم لغى
            }

            form.querySelector('input[name="password"]').value = password;
            return true; // يكمل الفورم
        }
    </script>
@endpush