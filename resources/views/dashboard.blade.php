
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">

        {{-- Filters --}}
        <form method="GET" class="row g-2 mb-4">

            <div class="col-md-4">
                <select name="center_id" class="form-control">
                    <option value="">🏫 كل المراكز</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select name="compare_center_id" class="form-control">
                    <option value="">📊 مقارنة</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}" {{ request('compare_center_id') == $center->id ? 'selected' : '' }}>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">عرض</button>
            </div>

        </form>

        {{-- Cards --}}
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>الطلاب</h6>
                        <h3>{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>حضور</h6>
                        <h3 class="text-success">{{ $presentCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>انصراف</h6>
                        <h3 class="text-primary">{{ $checkedOutCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>غياب</h6>
                        <h3 class="text-danger">{{ $absentCount }}</h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- Chart --}}
        <div class="card">
            <div class="card-body">
                <h5>📈 آخر 7 أيام</h5>
                <div style="height:300px">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- مهم جدًا --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const labels = @json($dates);
            const data1 = @json($center1Data);
            const data2 = @json($center2Data ?? []);

            const ctx = document.getElementById('attendanceChart');

            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'المركز الأساسي',
                            data: data1,
                            backgroundColor: 'rgba(40,167,69,0.7)'
                        },
                        {
                            label: 'المقارنة',
                            data: data2,
                            backgroundColor: 'rgba(13,110,253,0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

        });
    </script>
@endsection