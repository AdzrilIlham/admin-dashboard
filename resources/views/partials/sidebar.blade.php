<!-- Sidebar -->
<nav id="sidebar" class="bg-gradient-primary sidebar sidebar-dark accordion position-fixed vh-100" style="transition: all 0.3s ease;">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-3">
        <a class="text-white fw-bold text-decoration-none fs-5" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Admin Panel
        </a>
        <button id="sidebarCollapse" class="btn btn-sm btn-light text-primary rounded-circle">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <hr class="sidebar-divider my-0">

    <ul class="navbar-nav" id="accordionSidebar">
        <!-- Dashboard -->
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading text-uppercase text-white-50 small ps-3">Management</div>

        <!-- Collapsible Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseManagement" aria-expanded="true" aria-controls="collapseManagement">
                <i class="bi bi-folder2-open"></i>
                <span>Management</span>
            </a>
            <div id="collapseManagement" class="collapse {{ request()->is('skills*') || request()->is('projects*') ? 'show' : '' }}" data-bs-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('skills*') ? 'active' : '' }}" href="{{ route('skills.index') }}">
                        <i class="bi bi-code-slash me-2"></i> Skills
                    </a>
                    <a class="collapse-item {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                        <i class="bi bi-collection me-2"></i> Projects
                    </a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <!-- Others -->
        <div class="sidebar-heading text-uppercase text-white-50 small ps-3">Others</div>

        <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/profile') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>

    </ul>

    <hr class="sidebar-divider mt-auto">
    <div class="text-center small text-white-50 mb-3">
        Copyright © Your Website 2025
    </div>
</nav>
