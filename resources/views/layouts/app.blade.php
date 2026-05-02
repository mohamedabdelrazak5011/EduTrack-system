<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EduTrack-System')</title>

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
@yield('scripts')
<body class="bg-light">

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">

            <!-- ✅ Logo → Dashboard -->
            <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
                <span class="fw-bold">EduTrack-system</span>
            </a>

            <!-- ✅ Nav Buttons -->
            <div class="d-flex gap-2">
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-light">
                    👨‍🎓 الطلاب
                </a>

                <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-outline-success">
                    📊 الحضور
                </a>

                <a href="{{ url('/scan') }}" class="btn btn-sm btn-warning">
                    📟 الاسكان
                </a>
            </div>

        </div>
    </nav>

    <!-- ✅ Page Content -->
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ هنا المهم -->
    @stack('scripts')

</body>

</html>