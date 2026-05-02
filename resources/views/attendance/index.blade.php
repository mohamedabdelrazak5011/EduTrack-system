@extends('layouts.app')

@section('title', 'متابعة الحضور')

@section('content')
<div class="container">

    {{-- العنوان --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            📊 متابعة الحضور – {{ $date->format('Y-m-d') }}
        </h4>

        <a href="{{ route('attendance.export') }}" class="btn btn-success">
            📥 تحميل Excel
        </a>
    </div>

    {{-- اختيار اليوم --}}
    <form method="GET" action="{{ route('attendance.index') }}" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label">📅 اختر اليوم</label>
                <input
                    type="date"
                    name="date"
                    class="form-control"
                    value="{{ $date->format('Y-m-d') }}"
                    onchange="this.form.submit()"
                >
            </div>
        </div>
    </form>

    {{-- ✅ Chart ملخص اليوم --}}
    <div class="card mb-4">
        <div class="card-body text-center">
            <h6 class="mb-3">📈 ملخص اليوم</h6>

            <div style="max-width:300px;margin:auto">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- جدول الحضور --}}
    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>اسم الطالب</th>
                <th>الحالة</th>
                <th>وقت الحضور</th>
                <th>وقت الانصراف</th>
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
                data: [{{ $presentCount }}, {{ $absentCount }}],
                backgroundColor: ['#198754', '#dc3545'],
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
