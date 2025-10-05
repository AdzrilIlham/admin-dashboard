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
    
    <!-- Bootstrap Icons (untuk sidebar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Fix untuk sidebar fixed dan content layout */
        #wrapper {
            display: flex;
        }

        #sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        /* Sidebar collapsed - sembunyi ke kiri */
        #sidebar.collapsed {
            left: -250px;
        }

        #content-wrapper {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Content full width saat sidebar collapsed */
        #sidebar.collapsed ~ #content-wrapper {
            margin-left: 0;
        }

        /* Toggle button untuk mobile/desktop */
        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: #4e73df;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #sidebar:not(.collapsed) ~ * .sidebar-toggle {
            left: 265px;
        }

        .sidebar-toggle:hover {
            background: #2e59d9;
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            #sidebar {
                left: -250px;
            }

            #sidebar.show {
                left: 0;
            }

            #content-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                left: 15px !important;
            }
        }

        /* Pastikan container-fluid tidak tertutup */
        .container-fluid {
            padding: 1.5rem;
        }

        /* Fix untuk tabel responsive */
        .table-responsive {
            overflow-x: auto;
        }

        /* Fix untuk card shadow */
        .card {
            margin-bottom: 1.5rem;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Overlay untuk close sidebar di mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Toggle Button (Burger Menu) -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
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

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SB Admin 2 JS -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- SweetAlert2 (jika digunakan) -->
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
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const sidebarCollapseBtn = document.getElementById("sidebarCollapse");

            // Toggle sidebar dengan tombol burger utama
            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", function () {
                    sidebar.classList.toggle("collapsed");
                    
                    // Untuk mobile, tambahkan class 'show'
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle("show");
                        sidebarOverlay.classList.toggle("active");
                    }
                });
            }

            // Toggle dari tombol di dalam sidebar (opsional)
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener("click", function () {
                    sidebar.classList.toggle("collapsed");
                });
            }

            // Close sidebar saat klik overlay (mobile)
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener("click", function () {
                    sidebar.classList.remove("show");
                    sidebar.classList.add("collapsed");
                    sidebarOverlay.classList.remove("active");
                });
            }

            // Auto-close sidebar di mobile saat window resize
            window.addEventListener("resize", function () {
                if (window.innerWidth > 768) {
                    sidebarOverlay.classList.remove("active");
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>