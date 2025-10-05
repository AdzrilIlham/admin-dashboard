<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow-sm">
    <div class="container-fluid">
        <!-- Welcome Message & Breadcrumb -->
        <div class="d-flex align-items-center" style="margin-left: 10%;">
            <div>
                <h5 class="mb-0 font-weight-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h5>
                <small class="text-muted">
                    <i class="fas fa-clock mr-1"></i><span id="realtime-clock"></span> WIB
                </small>
            </div>
        </div>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Sidebar Toggle (Burger Menu) - Mobile -->
            <li class="nav-item d-md-none mr-2">
                <button id="sidebarToggleTop" class="btn btn-link rounded-circle">
                    <i class="fa fa-bars"></i>
                </button>
            </li>
            <!-- Quick Stats -->
            <li class="nav-item d-none d-lg-block mr-3">
                <div class="d-flex align-items-center">
                    <div class="text-center px-3 border-right">
                        <div class="text-xs text-muted">SKILLS</div>
                        <div class="font-weight-bold text-primary">{{ \App\Models\Skill::count() }}</div>
                    </div>
                    <div class="text-center px-3 border-right">
                        <div class="text-xs text-muted">PROJECTS</div>
                        <div class="font-weight-bold text-success">{{ \App\Models\Project::count() }}</div>
                    </div>
                    <div class="text-center px-3">
                        <div class="text-xs text-muted">VIEWS</div>
                        <div class="font-weight-bold text-info">{{ \App\Models\Visitor::sum('visit_count') }}</div>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <div class="topbar-divider d-none d-lg-block"></div>

            <!-- User Profile Dropdown -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 d-none d-lg-block text-right">
                            <span class="d-block font-weight-bold text-gray-800">{{ Auth::user()->name }}</span>
                            <small class="text-muted">Administrator</small>
                        </div>
                        @if(Auth::user()->avatar)
                            <img class="img-profile rounded-circle border border-primary" 
                                 src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                 style="width: 45px; height: 45px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center border border-primary"
                                 style="width: 45px; height: 45px; font-weight: bold; font-size: 1.1rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                </a>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('settings') }}">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); confirmLogout();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Logout Form (Hidden) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
.topbar {
    height: auto !important;
    padding: 0.75rem 0 !important;
}

.text-xs {
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.topbar-divider {
    width: 0;
    border-right: 1px solid #e3e6f0;
    height: 2.375rem;
    margin: auto 1rem;
}

.img-profile {
    width: 45px;
    height: 45px;
    object-fit: cover;
}

.dropdown-menu {
    font-size: 0.85rem;
}

.dropdown-item {
    padding: 0.5rem 1.5rem;
}

.dropdown-item:hover {
    background-color: #f8f9fc;
}

#sidebarToggleTop {
    color: #858796;
}

#sidebarToggleTop:hover {
    color: #4e73df;
}

/* Responsive */
@media (max-width: 768px) {
    .topbar h5 {
        font-size: 1rem;
    }
    
    .topbar small {
        font-size: 0.75rem;
    }
}
</style>

<script>
// Real-time Clock
function updateClock() {
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    const now = new Date();
    const dayName = days[now.getDay()];
    const day = String(now.getDate()).padStart(2, '0');
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    const timeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes}`;
    document.getElementById('realtime-clock').textContent = timeString;
}

// Update clock immediately and then every second
updateClock();
setInterval(updateClock, 1000);

// Logout Confirmation
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>
<!-- End of Topbar -->