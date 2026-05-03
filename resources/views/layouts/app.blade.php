<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EduTrack-System')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Vite (IMPORTANT) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f4f6f9;
            font-family: system-ui, sans-serif;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;

            background: linear-gradient(180deg, #0f172a, #111827);
            color: white;
            padding: 20px;

            display: flex;
            flex-direction: column;
        }

        /* LOGO */
        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
        }

        /* MENU */
        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* ITEM */
        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 12px;
            border-radius: 10px;

            color: #cbd5e1;
            text-decoration: none;

            transition: 0.2s ease;
        }

        /* HOVER */
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            transform: translateX(-3px);
        }

        /* ACTIVE */
        .menu-item.active {
            background: #4f46e5;
            color: #fff;
            font-weight: 600;
        }

        /* MAIN */
        .main-content {
            margin-right: 260px;
            padding: 20px;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* CARD */
        .card {
            border-radius: 14px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }
    </style>

</head>

<body>

    {{-- ================= SIDEBAR ================= --}}
    <div class="sidebar">

        <!-- LOGO -->

        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="EduTrack Logo" class="sidebar-logo">

            <h4>EduTrack</h4>
            <h6>Management System</h6>
        </div>


        <!-- MENU -->
        <nav class="sidebar-menu">

            <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>لوحة التحكم</span>
            </a>

            <a href="/students" class="menu-item {{ request()->is('students*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>الطلاب</span>
            </a>

            <a href="/attendance" class="menu-item {{ request()->is('attendance*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>الحضور</span>
            </a>

            <a href="/scan" class="menu-item {{ request()->is('scan') ? 'active' : '' }}">
                <i class="fa-solid fa-qrcode"></i>
                <span>Scan</span>
            </a>

        </nav>

    </div>

    {{-- ================= MAIN ================= --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <div class="topbar">
            <h4>@yield('title')</h4>
        </div>

        {{-- CONTENT --}}
        @yield('content')

    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    @push('scripts')
        <script>
            function confirmDelete(form) {
                const password = prompt("❗ أدخل الباسورد للتأكيد:");

                if (!password) {
                    return false;
                }

                form.querySelector('input[name="password"]').value = password;
                return true;
            }
        </script>
    @endpush
    ``



</body>

</html>