<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/Logo_IDS.png') }}" type="image/png">
    <title>@yield('title', 'Dashboard') - Sistem Anggaran</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }

        /* ===== HEADER ===== */
        .header {
            background: white;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-toggle {
            display: none;
            font-size: 20px;
            color: #2563eb;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: #f3f4f6;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 32px;
            display: block;
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            background: #e0e7ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #2563eb;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
            border: none;
        }

        .user-icon:hover {
            background: #c7d2fe;
        }

        .dropdown {
            position: absolute;
            top: 44px;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-5px);
            transition: all 0.2s ease;
            z-index: 1001;
            border: 1px solid #e5e7eb;
        }

        .dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .dropdown-greeting {
            font-size: 11px;
            color: #2563eb;
            margin-bottom: 3px;
        }

        .dropdown-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            font-size: 13px;
            word-wrap: break-word;
        }

        .dropdown-time {
            font-size: 11px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .dropdown-footer {
            padding: 8px 10px;
        }

        .logout-btn {
            width: 100%;
            padding: 8px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 52px;
            left: 0;
            width: 220px;
            height: calc(100vh - 52px);
            background: white;
            box-shadow: 1px 0 2px rgba(0, 0, 0, 0.03);
            padding: 16px 0;
            transition: all 0.3s ease;
            z-index: 900;
            overflow-y: auto;
            border-right: 1px solid #f1f5f9;
        }

        .menu-item {
            padding: 10px 18px;
            color: #4b5563;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            font-size: 13px;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .menu-item:hover {
            background: #f8fafc;
            color: #2563eb;
        }

        .menu-item.active {
            background: #eff6ff;
            color: #2563eb;
            border-left-color: #2563eb;
            font-weight: 600;
        }

        .menu-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 220px;
            margin-top: 52px;
            padding: 20px;
            min-height: calc(100vh - 52px);
            transition: all 0.3s ease;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-left: 220px;
            padding: 12px 20px;
            background: white;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: right;
            transition: all 0.3s ease;
        }

        .footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* ===== OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 52px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 899;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 340px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            animation: modalSlideIn 0.2s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            font-size: 20px;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-body {
            margin-bottom: 18px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-confirm {
            background: #ef4444;
            color: white;
        }

        .btn-confirm:hover {
            background: #dc2626;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .content {
                padding: 18px;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                left: -240px;
                width: 220px;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .footer {
                margin-left: 0;
            }

            .header {
                padding: 0 14px;
                height: 50px;
            }

            .logo img {
                height: 28px;
            }

            .user-icon {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .dropdown {
                right: -5px;
                width: 190px;
            }

            .content {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 12px;
                height: 48px;
            }

            .logo img {
                height: 26px;
            }

            .user-icon {
                width: 30px;
                height: 30px;
                font-size: 11px;
            }

            .dropdown {
                width: 180px;
            }

            .content {
                padding: 14px;
            }

            .footer {
                padding: 10px 16px;
                font-size: 11px;
            }
        }

        @media (min-width: 769px) {
            .menu-toggle {
                display: none !important;
            }

            .sidebar {
                left: 0 !important;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <div class="header-left">
            <div class="menu-toggle" onclick="toggleSidebar()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </div>
            <div class="logo">
                <img src="{{ asset('image/Logo_IDSurvey.png') }}" alt="Logo">
            </div>
        </div>

        <div class="user-menu">
            <button class="user-icon" onclick="toggleDropdown()" aria-label="User Menu">
                {{ strtoupper(substr(Auth::user()->nama ?? (Auth::user()->name ?? 'U'), 0, 1)) }}
            </button>

            <div class="dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-greeting" id="greeting">Selamat Pagi</div>
                    <div class="dropdown-name">{{ Auth::user()->nama ?? (Auth::user()->name ?? 'User') }}</div>
                    <div class="dropdown-time">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="currentTime"></span>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <button class="logout-btn" onclick="showLogoutModal()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- OVERLAY -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('master.anggaran') }}"
            class="menu-item {{ request()->routeIs('master.anggaran') || request()->routeIs('master.anggaran.*') ? 'active' : '' }}">
            <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Master Anggaran
        </a>

        <a href="{{ route('pum.input') }}" class="menu-item {{ request()->routeIs('pum.input') ? 'active' : '' }}">
            <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Input PUM/SPP
        </a>

        <a href="{{ route('pum.history') }}"
            class="menu-item {{ request()->routeIs('pum.history') || request()->routeIs('pum.edit') ? 'active' : '' }}">
            <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            History PUM/SPP
        </a>
    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <span>© {{ date('Y') }} Sistem Anggaran - Integrasi Sistem dan Proses Bisnis</span>
    </div>

    <!-- MODAL LOGOUT -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-icon">⚠</div>
                <div class="modal-title">Konfirmasi Keluar</div>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin keluar dari aplikasi?
            </div>
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="hideLogoutModal()">Batal</button>
                <button class="btn btn-confirm" onclick="confirmLogout()">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <!-- LOGOUT FORM -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebarOverlay");
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
        }

        function closeSidebar() {
            document.getElementById("sidebar").classList.remove("show");
            document.getElementById("sidebarOverlay").classList.remove("show");
        }

        // Toggle Dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("active");
        }

        // Close dropdown ketika klik di luar
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');

            if (!userMenu.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Update Time and Greeting
        function updateTimeAndGreeting() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            // Update time
            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;

            // Update greeting
            let greeting = '';
            if (hours >= 5 && hours < 11) {
                greeting = 'Selamat Pagi';
            } else if (hours >= 11 && hours < 15) {
                greeting = 'Selamat Siang';
            } else if (hours >= 15 && hours < 18) {
                greeting = 'Selamat Sore';
            } else {
                greeting = 'Selamat Malam';
            }

            document.getElementById('greeting').textContent = greeting;
        }

        // Update every second
        setInterval(updateTimeAndGreeting, 1000);
        updateTimeAndGreeting();

        // Modal Logout Functions
        function showLogoutModal() {
            document.getElementById('userDropdown').classList.remove('active');
            document.getElementById('logoutModal').classList.add('active');
        }

        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }

        function confirmLogout() {
            document.getElementById('logoutForm').submit();
        }

        // Close modal dengan ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideLogoutModal();
                document.getElementById('userDropdown').classList.remove('active');
            }
        });

        // Auto close sidebar on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>