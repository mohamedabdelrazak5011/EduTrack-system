@extends('layouts.app')

@section('title', 'QR Code الطالب')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card text-center shadow-sm" id="printArea">

                <div class="card-header bg-dark text-white">
                    QR Code الطالب
                </div>

                <div class="card-body">

                    {{-- الاسم --}}
                    <h5 class="mb-2">{{ $student->name }}</h5>

                    {{-- كود الطالب --}}
                    <p class="text-muted mb-3">
                        {{ $student->student_code }}
                    </p>

                    {{-- QR Code --}}
                    <div class="d-flex justify-content-center mb-3">
                        {!! QrCode::size(220)->generate($student->student_code) !!}
                    </div>

                    {{-- معلومات إضافية (مهمة للمدرسة) --}}
                    <div class="small text-muted">
                        <div>📞 {{ $student->parent_phone ?? '—' }}</div>
                        <div>🏫 {{ $student->center->name ?? '—' }}</div>
                    </div>

                    {{-- زر الطباعة --}}
                    <a href="{{ route('students.qr', $student->id) }}" class="btn btn-success w-100 mt-3">
                        📥 تحميل QR
                    </a>

                </div>
            </div>

        </div>

    </div>

@endsection