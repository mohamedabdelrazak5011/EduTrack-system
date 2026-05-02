@extends('layouts.app')

@section('content')

    <form method="GET" class="mb-4">

        {{-- السنتر الأساسي --}}
        <select name="center_id" onchange="this.form.submit()" class="form-control w-25">
            <option value="">اختر المركز</option>

            @foreach($centers as $center)
                <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>

        {{-- سنتر المقارنة --}}
        <select name="compare_center_id" onchange="this.form.submit()" class="form-control w-25 mt-2">
            <option value="">اختر سنتر للمقارنة</option>

            @foreach($centers as $center)
                <option value="{{ $center->id }}" {{ request('compare_center_id') == $center->id ? 'selected' : '' }}>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>

    </form>

    <h2 class="mb-4">📊 Dashboard – {{ $today->format('d M Y') }}</h2>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="card bg-dark text-white mb-3">
                <div class="card-body text-center">
                    <h5>🎓 عدد الطلاب</h5>
                    <h2>{{ $totalStudents }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-body text-center">
                    <h5>✅ الحاضرين</h5>
                    <h2>{{ $presentCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body text-center">
                    <h5>🚪 المنصرفين</h5>
                    <h2>{{ $checkedOutCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white mb-3">
                <div class="card-body text-center">
                    <h5>❌ الغياب</h5>
                    <h2>{{ $absentCount }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="card mt-4">
        <div class="card-body">
            <h5>📈 الحضور آخر 7 أيام</h5>

            <div style="height: 300px;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const labels = {!! json_encode($dates) !!};
            const center1 = {!! json_encode($center1Data) !!};
            const center2 = {!! json_encode($center2Data ?? []) !!};

            const ctx = document.getElementById('attendanceChart');

            new Chart(ctx, {
                type: 'bar', // 🔥 Bar Chart احترافي
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'السنتر الأساسي',
                            data: center1,
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderRadius: 6
                        },
                        {
                            label: 'سنتر المقارنة',
                            data: center2,
                            backgroundColor: 'rgba(0, 123, 255, 0.7)',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart'
                    },

                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });

        });
    </script>

@endsection