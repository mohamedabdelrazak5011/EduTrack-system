@extends('layouts.app')

@section('title', 'متابعة الحضور')

@section('content')

    <div class="container-fluid px-4">

        {{-- ========================= --}}
        {{-- 🧢 PAGE HEADER --}}
        {{-- ========================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    📊 متابعة الحضور
                    <small class="text-muted">
                        ({{ $date->format('Y-m-d') }})
                    </small>
                </h4>

                <a href="{{ route('attendance.export', request()->all()) }}" class="btn btn-success">
                    📥 تحميل Excel
                </a>

            </div>
        </div>

        {{-- ========================= --}}
        {{-- 🔍 FILTER SECTION --}}
        {{-- ========================= --}}
        <form method="GET" action="{{ route('attendance.index') }}" class="card shadow-sm border-0 mb-4">

            <div class="card-body">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label text-muted">📅 يوم محدد</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted">📍 من</label>
                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted">📍 إلى</label>
                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            فلترة
                        </button>
                    </div>

                </div>
            </div>
        </form>

        {{-- ========================= --}}
        {{-- 📈 SUMMARY / CHART --}}
        {{-- ========================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center">

                <h6 class="mb-3">📈 ملخص الحضور</h6>

                <div style="max-width:280px;margin:auto">
                    <canvas id="attendanceChart"></canvas>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <span class="badge bg-success px-3 py-2">
                            حضور: {{ $presentCount }}
                        </span>
                    </div>
                    <div class="col">
                        <span class="badge bg-danger px-3 py-2">
                            غياب: {{ $absentCount }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ========================= --}}
        {{-- 📋 TABLE --}}
        {{-- ========================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">

                <table class="table table-hover text-center align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الحالة</th>
                            <th>الحضور</th>
                            <th>الانصراف</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($students as $student)

                            @php
                                $record = $attendance[$student->id] ?? null;
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $student->name }}</td>

                                <td>
                                    @if($record)
                                        @if($record->check_out)
                                            <span class="badge bg-primary">انصراف</span>
                                        @else
                                            <span class="badge bg-success">حضور</span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">غايب</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $record?->check_in?->format('h:i A') ?? '-' }}
                                </td>

                                <td>
                                    {{ $record?->check_out?->format('h:i A') ?? '-' }}
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const ctx = document.getElementById('attendanceChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['حضور', 'غياب'],
                    datasets: [{
                        data: [
                        {{ $presentCount }},
                            {{ $absentCount }}
                        ],
                        backgroundColor: ['#198754', '#dc3545']
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    cutout: '65%'
                }
            });

        });
    </script>
@endpush