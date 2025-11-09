<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            background-color: #f8f9fc;
        }

        /* ============================================
           DARK MODE STYLES
        ============================================ */
        body.dark-mode {
            background-color: #0f0f1e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode #wrapper {
            background-color: #0f0f1e !important;
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%) !important;
        }

        body.dark-mode .topbar {
            background-color: #1a1a2e !important;
            border-bottom: 1px solid #2d2d44 !important;
        }

        body.dark-mode .navbar-light .navbar-brand,
        body.dark-mode .navbar-light .navbar-nav .nav-link {
            color: #e0e0e0 !important;
        }

        body.dark-mode .card {
            background-color: #1a1a2e !important;
            border-color: #2d2d44 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header {
            background-color: #16213e !important;
            border-bottom-color: #2d2d44 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table {
            color: #e0e0e0 !important;
            border-color: #2d2d44 !important;
            background-color: #1a1a2e !important;
        }

        body.dark-mode .table thead th {
            background-color: #16213e !important;
            color: #e0e0e0 !important;
            border-color: #2d2d44 !important;
        }

        body.dark-mode .table tbody td {
            border-color: #2d2d44 !important;
            background-color: #1a1a2e !important;
        }

        body.dark-mode .form-control {
            background-color: #16213e !important;
            border-color: #2d2d44 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #16213e !important;
            border-color: #4e73df !important;
            color: #e0e0e0 !important;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
        }

        body.dark-mode .progress {
            background-color: #2d2d44 !important;
        }

        body.dark-mode .text-muted {
            color: #a0a0a0 !important;
        }

        body.dark-mode .border {
            border-color: #2d2d44 !important;
        }

        /* ============================================
           SIDEBAR STYLES
        ============================================ */
        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 14rem !important;
            height: 100vh !important;
            z-index: 1000 !important;
            background: linear-gradient(180deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%) !important;
            box-shadow: 4px 0 15px rgba(79, 70, 229, 0.3) !important;
            transition: transform 0.3s ease-in-out !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .sidebar .sidebar-brand {
            background-color: rgba(0, 0, 0, 0.2) !important;
            color: #ffffff !important;
            padding: 1.5rem 1rem !important;
            font-weight: 700 !important;
            font-size: 1.2rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            text-align: center;
        }

        .sidebar .sidebar-heading {
            color: rgba(255, 255, 255, 0.5) !important;
            text-transform: uppercase !important;
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            padding: 0.75rem 1rem !important;
            margin-top: 0.5rem !important;
        }

        .sidebar .nav-item {
            margin: 0.25rem 0.5rem !important;
        }

        .sidebar .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 0.75rem 1rem !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
        }

        .sidebar .nav-item .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
            text-align: center;
        }

        .sidebar .nav-item .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.15) !important;
            transform: translateX(5px) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
        }

        .sidebar .nav-item.active .nav-link,
        .sidebar .nav-item .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.25) !important;
            border-left: 4px solid #ffffff !important;
            padding-left: calc(1rem - 4px) !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
            margin: 0.75rem 1rem !important;
        }

        /* Hide default SB Admin toggle buttons */
        .sidebar #sidebarToggle,
        #sidebarToggleTop,
        .sidebar .fa-bars,
        .sidebar .sidebar-toggler,
        .sidebar .text-center button,
        .sidebar-brand-icon .fa-bars,
        .sidebar button[id*="toggle"],
        .sidebar .rounded-circle {
            display: none !important;
        }

        /* ============================================
           SIDEBAR TOGGLE BUTTON
        ============================================ */
        .sidebar-toggle {
            position: fixed !important;
            top: 15px !important;
            left: 250px !important;
            z-index: 1001 !important;
            background: #4e73df !important;
            border: none !important;
            color: white !important;
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
            transition: all 0.3s ease !important;
            pointer-events: auto !important;
        }

        .sidebar-toggle:hover {
            background: #2e59d9 !important;
            transform: scale(1.05) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4) !important;
        }

        .hamburger-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 18px;
            height: 14px;
        }

        .hamburger-icon span {
            display: block;
            width: 100%;
            height: 2px;
            background-color: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* ============================================
           CONTENT WRAPPER & MAIN CONTENT
        ============================================ */
        #content-wrapper {
            width: 100% !important;
            margin-left: 14rem !important;
            transition: margin-left 0.3s ease-in-out !important;
            min-height: 100vh !important;
            background-color: #f8f9fc;
        }

        body.dark-mode #content-wrapper {
            background-color: #0f0f1e !important;
        }

        #content {
            flex: 1 0 auto;
            padding-top: 0 !important;
        }

        /* Main Content Area */
        .main-content {
            padding: 2rem 0;
        }

        /* Page Heading */
        .page-heading {
            margin-bottom: 2rem;
            padding: 0 1.5rem;
        }

        /* ============================================
           TOPBAR STYLES
        ============================================ */
        .topbar {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        body.dark-mode .topbar {
            background-color: #1a1a2e;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .navbar-brand {
            font-weight: 700;
            color: #4e73df !important;
        }

        .navbar-nav .nav-link {
            color: #5a5c69 !important;
            font-weight: 500;
        }

        body.dark-mode .navbar-nav .nav-link {
            color: #e0e0e0 !important;
        }

        /* ============================================
           CARD STYLES
        ============================================ */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
            transform: translateY(-2px);
        }

        .card-header {
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.5rem;
            background-color: #ffffff;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ============================================
           TABLE STYLES
        ============================================ */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-color: #e3e6f0;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.1);
        }

        /* ============================================
           PROGRESS BAR STYLES
        ============================================ */
        .progress {
            height: 20px;
            background-color: #eaecf4;
            border-radius: 0.35rem;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #4e73df 0%, #1cc88a 100%);
            transition: width 0.6s ease;
            position: relative;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* ============================================
           BUTTON STYLES
        ============================================ */
        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* ============================================
           BADGE STYLES
        ============================================ */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35em 0.65em;
        }

        /* ============================================
           SIDEBAR OVERLAY (Mobile)
        ============================================ */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999 !important;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block !important;
            opacity: 1 !important;
        }

        /* ============================================
           SIDEBAR STATES
        ============================================ */
        /* Desktop - Sidebar Hidden */
        body.sidebar-hidden .sidebar {
            transform: translateX(-100%) !important;
        }

        body.sidebar-hidden #content-wrapper {
            margin-left: 0 !important;
        }

        body.sidebar-hidden .sidebar-toggle {
            left: 20px !important;
        }

        /* Desktop - Sidebar Visible */
        body:not(.sidebar-hidden) .sidebar {
            transform: translateX(0) !important;
        }

        /* ============================================
           MODAL STYLES
        ============================================ */
        .modal-backdrop {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            z-index: 1040 !important;
            width: 100vw !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            opacity: 1 !important;
            display: block !important;
        }

        .modal-content {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .modal-header {
            border-bottom: 1px solid #e3e6f0;
            padding: 1.25rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e3e6f0;
            padding: 1.25rem 1.5rem;
        }

        /* ============================================
           FORM STYLES
        ============================================ */
        .form-control {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-range {
            padding: 0.5rem 0;
        }

        /* ============================================
           RESPONSIVE STYLES
        ============================================ */
        @media (max-width: 1200px) {
            .sidebar {
                width: 12rem !important;
            }
            
            #content-wrapper {
                margin-left: 12rem !important;
            }
            
            .sidebar-toggle {
                left: 220px !important;
            }
        }

        @media (max-width: 992px) {
            .card-body {
                padding: 1.25rem;
            }
            
            .page-heading {
                padding: 0 1rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%) !important;
                width: 16rem !important;
            }

            #content-wrapper {
                margin-left: 0 !important;
            }

            body.sidebar-visible .sidebar {
                transform: translateX(0) !important;
            }

            .sidebar-toggle {
                left: 20px !important;
                top: 15px !important;
            }

            body.sidebar-visible .sidebar-toggle {
                left: 20px !important;
            }

            .main-content {
                padding: 1.5rem 0;
            }

            .page-heading {
                margin-bottom: 1.5rem;
                padding: 0 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .btn-group .btn {
                border-radius: 0.35rem !important;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem 0;
            }

            .page-heading {
                margin-bottom: 1rem;
            }

            .page-heading h1 {
                font-size: 1.5rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem 0.25rem;
                font-size: 0.8rem;
            }

            .progress {
                height: 16px;
            }

            .badge {
                font-size: 0.7rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-content {
                border-radius: 0.5rem;
            }
        }

        @media (max-width: 400px) {
            .sidebar {
                width: 14rem !important;
            }
            
            .d-sm-flex {
                flex-direction: column;
                gap: 1rem;
            }
            
            .d-sm-flex .btn {
                align-self: flex-start;
            }
        }

        /* ============================================
           SCROLL TO TOP BUTTON
        ============================================ */
        .scroll-to-top {
            position: fixed;
            right: 1.5rem;
            bottom: 1.5rem;
            display: none;
            width: 3rem;
            height: 3rem;
            text-align: center;
            color: #fff;
            background: rgba(78, 115, 223, 0.8);
            line-height: 46px;
            border-radius: 50%;
            z-index: 900;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .scroll-to-top:hover {
            background: #4e73df;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        /* ============================================
           UTILITY CLASSES
        ============================================ */
        .shadow-custom {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .border-radius-custom {
            border-radius: 0.5rem !important;
        }

        .text-primary-custom {
            color: #4e73df !important;
        }

        .bg-gradient-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Overlay untuk Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Toggle Button -->
        <button class="sidebar-toggle" id="sidebarToggle" type="button">
            <div class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>

        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid main-content">
                    <div class="page-heading">
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('partials.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- SB Admin 2 -->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            position: 'top',
            toast: true
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard Scripts Loaded');

            // ========== DARK MODE ==========
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
            }

            // ========== SIDEBAR TOGGLE ==========
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const body = document.body;
            
            const isMobile = () => window.innerWidth < 768;

            function setInitialState() {
                if (isMobile()) {
                    body.classList.remove('sidebar-visible');
                    body.classList.remove('sidebar-hidden');
                } else {
                    body.classList.remove('sidebar-visible');
                    body.classList.remove('sidebar-hidden');
                }
            }

            setInitialState();

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (isMobile()) {
                        body.classList.toggle('sidebar-visible');
                        sidebarOverlay.classList.toggle('active');
                    } else {
                        body.classList.toggle('sidebar-hidden');
                    }
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    body.classList.remove('sidebar-visible');
                    sidebarOverlay.classList.remove('active');
                });
            }

            const sidebarLinks = document.querySelectorAll('.sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (isMobile()) {
                        body.classList.remove('sidebar-visible');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });

            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (isMobile()) {
                        body.classList.remove('sidebar-hidden');
                        if (!body.classList.contains('sidebar-visible')) {
                            sidebarOverlay.classList.remove('active');
                        }
                    } else {
                        body.classList.remove('sidebar-visible');
                        sidebarOverlay.classList.remove('active');
                    }
                }, 250);
            });

            // ========== SCROLL TO TOP ==========
            const scrollToTop = document.querySelector('.scroll-to-top');
            
            window.addEventListener('scroll', function() {
                if (scrollToTop) {
                    if (window.pageYOffset > 100) {
                        scrollToTop.style.display = 'block';
                    } else {
                        scrollToTop.style.display = 'none';
                    }
                }
            });

            if (scrollToTop) {
                scrollToTop.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // ========== CARD HOVER EFFECTS ==========
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // ========== RESPONSIVE TABLE ==========
            function adjustTableLayout() {
                const tables = document.querySelectorAll('.table-responsive');
                tables.forEach(table => {
                    if (window.innerWidth < 576) {
                        table.classList.add('small-table');
                    } else {
                        table.classList.remove('small-table');
                    }
                });
            }

            adjustTableLayout();
            window.addEventListener('resize', adjustTableLayout);

            // ========== MODAL FIX ==========
            const modals = document.querySelectorAll('.modal');
            
            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function(e) {
                    console.log('Modal opening:', this.id);
                    
                    const sidebarOverlay = document.getElementById('sidebarOverlay');
                    if (sidebarOverlay) {
                        sidebarOverlay.style.display = 'none';
                    }
                    
                    setTimeout(() => {
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.style.zIndex = '1040';
                            backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
                            backdrop.style.opacity = '1';
                            backdrop.style.display = 'block';
                        }
                        
                        this.style.zIndex = '1055';
                        
                        const sidebar = document.querySelector('.sidebar');
                        const sidebarToggle = document.querySelector('.sidebar-toggle');
                        
                        if (sidebar) sidebar.style.zIndex = '1000';
                        if (sidebarToggle) sidebarToggle.style.zIndex = '1000';
                    }, 50);
                });
                
                modal.addEventListener('shown.bs.modal', function(e) {
                    const formElements = this.querySelectorAll('input, select, textarea, button, .btn');
                    formElements.forEach(el => {
                        el.style.pointerEvents = 'auto';
                    });
                    
                    const firstInput = this.querySelector('input:not([type="hidden"])');
                    if (firstInput) {
                        firstInput.focus();
                    }
                });
                
                modal.addEventListener('hidden.bs.modal', function(e) {
                    const sidebar = document.querySelector('.sidebar');
                    const sidebarToggle = document.querySelector('.sidebar-toggle');
                    
                    if (sidebar) sidebar.style.zIndex = '1000';
                    if (sidebarToggle) sidebarToggle.style.zIndex = '1001';
                    
                    const sidebarOverlay = document.getElementById('sidebarOverlay');
                    if (sidebarOverlay && document.body.classList.contains('sidebar-visible')) {
                        sidebarOverlay.style.display = 'block';
                    }
                });
            });

            // Fix existing backdrop
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) {
                existingBackdrop.style.zIndex = '1040';
                existingBackdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
                existingBackdrop.style.opacity = '1';
            }

            // Pastikan backdrop tidak transparan
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-backdrop')) {
                    e.target.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
                    e.target.style.opacity = '1';
                }
            });

            // ========== AUTO-HIDE ALERTS ==========
            const autoHideAlerts = document.querySelectorAll('.alert-auto-hide');
            autoHideAlerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // jQuery Modal Fix (Alternative)
        if (typeof jQuery !== 'undefined') {
            $(document).ready(function() {
                $('.modal').on('show.bs.modal', function() {
                    $('.sidebar, .sidebar-toggle').css('z-index', '1000');
                    $('#sidebarOverlay').hide();
                });
                
                $('.modal').on('shown.bs.modal', function() {
                    setTimeout(function() {
                        $('.modal-backdrop').css({
                            'z-index': '1040',
                            'background-color': 'rgba(0, 0, 0, 0.6)',
                            'opacity': '1',
                            'display': 'block'
                        });
                    }, 50);
                });
                
                $('.modal').on('hidden.bs.modal', function() {
                    $('.sidebar').css('z-index', '1000');
                    $('.sidebar-toggle').css('z-index', '1001');
                });
            });
        }
    </script>

    @stack('scripts')

</body>

</html>