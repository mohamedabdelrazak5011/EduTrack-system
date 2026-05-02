@extends('layouts.app')

@section('title', 'متابعة الحضور')

@section('content')

<div class="container">

    {{-- ========================= --}}
    {{-- 🔍 FILTER SECTION --}}
    {{-- ========================= --}}
    <form method="GET" action="{{ route('attendance.index') }}" class="row g-2 mb-3">

        <div class="col-md-3">
            <label>📅 يوم محدد</label>
            <input type="date" name="date" class="form-control"
                   value="{{ request('date') }}">
        </div>

        <div class="col-md-3">
            <label>📍 من</label>
            <input type="date" name="from" class="form-control"
                   value="{{ request('from') }}">
        </div>

        <div class="col-md-3">
            <label>📍 إلى</label>
            <input type="date" name="to" class="form-control"
                   value="{{ request('to') }}">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">فلترة</button>
        </div>

    </form>

    {{-- ========================= --}}
    {{-- HEADER + EXPORT --}}
    {{-- ========================= --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>
            📊 متابعة الحضور
            <small class="text-muted">
                ({{ $date->format('Y-m-d') }})
            </small>
        </h4>

        <a href="{{ route('attendance.export', request()->all()) }}"
           class="btn btn-success">
            📥 تحميل Excel
        </a>

    </div>

    {{-- ========================= --}}
    {{-- CHART --}}
    {{-- ========================= --}}
    <div class="card mb-4">
        <div class="card-body text-center">
            <h6>📈 ملخص الحضور</h6>

            <div style="max-width:300px;margin:auto">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <table class="table table-bordered text-center align-middle">

        <thead class="table-dark">
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
                <td>{{ $student->name }}</td>

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

                <td>{{ $record?->check_in?->format('h:i A') ?? '-' }}</td>
                <td>{{ $record?->check_out?->format('h:i A') ?? '-' }}</td>
            </tr>

        @endforeach
        </tbody>

    </table>

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