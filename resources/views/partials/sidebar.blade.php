<!-- Sidebar -->
<nav id="sidebar" class="bg-gradient-primary sidebar sidebar-dark accordion position-fixed vh-100" style="transition: all 0.3s ease;">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-3">
        <a class="text-white fw-bold text-decoration-none fs-5" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Admin Panel
        </a>
        <button id="sidebarCollapse" class="btn btn-sm btn-light text-primary rounded-circle">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <hr class="sidebar-divider my-0">

    <ul class="navbar-nav" id="accordionSidebar">
        
        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Portfolio Section -->
        <div class="sidebar-heading text-uppercase text-white-50 small ps-3">
            Portfolio Management
        </div>

        <!-- Portfolio Collapsible Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePortfolio"
                aria-expanded="false" aria-controls="collapsePortfolio">
                <i class="bi bi-folder-check"></i>
                <span>Portfolio</span>
            </a>

            <div id="collapsePortfolio" 
                 class="collapse {{ request()->is('admin/portfolio*') ? 'show' : '' }}" 
                 data-bs-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item {{ request()->routeIs('admin.portfolio.index') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio.index') }}">
                        <i class="bi bi-info-circle me-2"></i> About
                    </a>

                    <a class="collapse-item {{ request()->routeIs('admin.portfolio.skills.*') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio.index') }}#skills-section">
                        <i class="bi bi-code-slash me-2"></i> Skills
                    </a>

                    <a class="collapse-item {{ request()->routeIs('admin.portfolio.projects.*') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio.index') }}#projects-section">
                        <i class="bi bi-kanban me-2"></i> Projects
                    </a>

                    <a class="collapse-item {{ request()->routeIs('admin.portfolio.certificates.*') ? 'active' : '' }}"
                        href="{{ route('admin.portfolio.index') }}#certificates-section">
                        <i class="bi bi-award me-2"></i> Certificates
                    </a>

                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <!-- Inbox Section -->
        <div class="sidebar-heading text-uppercase text-white-50 small ps-3">
            Inbox
        </div>

        <li class="nav-item {{ request()->is('admin/contacts*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                <i class="bi bi-envelope"></i>
                <span>Contact Inbox</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Profile -->
        <div class="sidebar-heading text-uppercase text-white-50 small ps-3">
            Others
        </div>

        <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/profile') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>

    </ul>

    <hr class="sidebar-divider mt-auto">
    <div class="text-center small text-white-50 mb-3">
        © Your Website 2025
    </div>
</nav>
