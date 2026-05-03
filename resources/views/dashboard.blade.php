@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-3">

        {{-- ================= FILTERS ================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label text-muted">🏫 المركز</label>
                        <select name="center_id" class="form-control input">
                            <option value="">كل المراكز</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted">📊 المقارنة</label>
                        <select name="compare_center_id" class="form-control input">
                            <option value="">بدون مقارنة</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ request('compare_center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary w-100 btn-primary">
                            عرض البيانات
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ================= STATS ================= --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card text-center p-3 border-start border-4 border-primary">
                    <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                    <div class="text-muted">الطلاب</div>
                    <h3 class="fw-bold">{{ $totalStudents }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 border-start border-4 border-success">
                    <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                    <div class="text-muted">حضور</div>
                    <h3 class="fw-bold text-success">{{ $presentCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 border-start border-4 border-info">
                    <i class="fas fa-sign-out-alt fa-2x text-info mb-2"></i>
                    <div class="text-muted">انصراف</div>
                    <h3 class="fw-bold text-info">{{ $checkedOutCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center p-3 border-start border-4 border-danger">
                    <i class="fas fa-user-times fa-2x text-danger mb-2"></i>
                    <div class="text-muted">غياب</div>
                    <h3 class="fw-bold text-danger">{{ $absentCount }}</h3>
                </div>
            </div>

        </div>

        {{-- ================= CHART ================= --}}
        <div class="card">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">📈 آخر 7 أيام</h5>
            </div>

            <div class="card-body">
                <div style="height:320px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- ================= SCRIPTS ================= --}}
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
                            backgroundColor: 'rgba(99,102,241,0.7)',
                            borderRadius: 8
                        },
                        {
                            label: 'المقارنة',
                            data: data2,
                            backgroundColor: 'rgba(16,185,129,0.7)',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
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