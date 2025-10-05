<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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
        }

        /* Sidebar Toggle Button - Hamburger Menu dengan Lingkaran */
        .sidebar-toggle {
            position: fixed !important;
            top: 20px !important;
            left: 250px !important;
            z-index: 10001 !important;
            background: #4e73df !important;
            border: none !important;
            color: white !important;
            width: 45px !important;
            height: 45px !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important;
            transition: all 0.3s ease !important;
            pointer-events: auto !important;
        }

        .sidebar-toggle:hover {
            background: #2e59d9 !important;
            transform: scale(1.05) !important;
        }

        .sidebar-toggle:active {
            transform: scale(0.95) !important;
        }

        .sidebar-toggle i {
            font-size: 20px !important;
            font-weight: 600 !important;
        }

        /* Hamburger Icon - Garis Tiga */
        .hamburger-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 22px;
            height: 16px;
        }

        .hamburger-icon span {
            display: block;
            width: 100%;
            height: 2.5px;
            background-color: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Sembunyikan toggle button bawaan SB Admin 2 di sidebar dan topbar */
        .sidebar #sidebarToggle,
        .sidebar .sidebar-brand .sidebar-brand-icon button,
        .sidebar .nav-item button[data-toggle],
        #sidebarToggleTop,
        .topbar #sidebarToggleTop,
        .sidebar-heading button,
        .sidebar .sidebar-brand button,
        .sidebar-brand-icon button,
        .sidebar button[data-toggle="collapse"],
        .sidebar .rounded-circle,
        .sidebar .btn-link {
            display: none !important;
        }
        
        /* Sembunyikan elemen dengan garis tiga dan lingkaran putih di sidebar */
        .sidebar .fa-bars,
        .sidebar .fas.fa-bars,
        .sidebar i.fa-bars {
            display: none !important;
        }

        /* Sidebar Base Styles - Override SB Admin 2 */
        .sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 14rem !important;
            height: 100vh !important;
            z-index: 1000 !important;
            transition: transform 0.3s ease-in-out !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Content Wrapper */
        #content-wrapper {
            width: 100% !important;
            margin-left: 14rem !important;
            transition: margin-left 0.3s ease-in-out !important;
            min-height: 100vh !important;
        }

        /* Overlay untuk Mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block !important;
            opacity: 1 !important;
        }

        /* Sidebar Hidden State - Desktop */
        body.sidebar-hidden .sidebar {
            transform: translateX(-100%) !important;
        }

        body.sidebar-hidden #content-wrapper {
            margin-left: 0 !important;
        }

        body.sidebar-hidden .sidebar-toggle {
            left: 20px !important;
        }

        /* Sidebar Visible State - Desktop */
        body:not(.sidebar-hidden) .sidebar {
            transform: translateX(0) !important;
        }

        body:not(.sidebar-hidden) .sidebar-toggle {
            left: 250px !important;
            transition: left 0.3s ease !important;
            z-index: 10001 !important;
        }
        
        /* Pastikan button selalu di atas sidebar */
        .sidebar-toggle {
            z-index: 10001 !important;
        }

        /* Mobile Responsive */
        @media (max-width: 767px) {
            /* Sidebar default hidden di mobile */
            .sidebar {
                transform: translateX(-100%) !important;
            }

            #content-wrapper {
                margin-left: 0 !important;
            }

            /* Sidebar visible di mobile */
            body.sidebar-visible .sidebar {
                transform: translateX(0) !important;
            }

            body:not(.sidebar-visible) .sidebar {
                transform: translateX(-100%) !important;
            }

            /* Button selalu di kiri di mobile */
            .sidebar-toggle {
                left: 20px !important;
            }

            body.sidebar-visible .sidebar-toggle {
                left: 20px !important;
            }
        }

        /* Container & General Styles */
        .container-fluid {
            padding: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card {
            margin-bottom: 1.5rem;
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            display: none;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, 0.5);
            line-height: 46px;
            border-radius: 0.35rem;
            z-index: 900;
            text-decoration: none;
        }

        .scroll-to-top:hover {
            background: #5a5c69;
            color: #fff;
        }

        .scroll-to-top:focus {
            outline: none;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Overlay untuk Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Toggle Button - Hamburger Menu (Di Luar Sidebar dengan Lingkaran) -->
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
                <div class="container-fluid">
                    @yield('content')
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
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SB Admin 2 JS -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
    

    <script>
        // Vanilla JavaScript untuk Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const body = document.body;
            
            // Function untuk cek apakah mobile
            const isMobile = () => window.innerWidth < 768;

            // Set initial state saat load
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

            // Toggle sidebar ketika button diklik
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Toggle clicked! Window width:', window.innerWidth);

                    if (isMobile()) {
                        // Mobile: toggle visible class
                        body.classList.toggle('sidebar-visible');
                        sidebarOverlay.classList.toggle('active');
                        console.log('Mobile mode - Sidebar visible:', body.classList.contains('sidebar-visible'));
                    } else {
                        // Desktop: toggle hidden class
                        body.classList.toggle('sidebar-hidden');
                        console.log('Desktop mode - Sidebar hidden:', body.classList.contains('sidebar-hidden'));
                    }
                });
            }

            // Close sidebar ketika overlay diklik (mobile)
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    body.classList.remove('sidebar-visible');
                    sidebarOverlay.classList.remove('active');
                });
            }

            // Close sidebar ketika link diklik (mobile)
            const sidebarLinks = document.querySelectorAll('.sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (isMobile()) {
                        body.classList.remove('sidebar-visible');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });

            // Handle window resize
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

            // Scroll to top button functionality
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
        });
    </script>

    @stack('scripts')

</body>

</html>