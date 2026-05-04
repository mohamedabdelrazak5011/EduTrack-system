<div class="sidebar">

    <!-- LOGO -->
    <div class="sidebar-header mb-4">
        <span class="fs-3">🏫</span>
        <h4 class="mt-2 mb-0">EduTrack</h4>
        <small class="text-muted">Management System</small>
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
            <span>الـ Scan</span>
        </a>

    </nav>

</div>