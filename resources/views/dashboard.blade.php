@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
        </h1>
        <div>
            <span class="text-muted"><i class="far fa-calendar-alt mr-1"></i>{{ now()->format('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row">
        <!-- Total Skills Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Skills
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalSkills }}
                            </div>
                            <div class="text-xs mt-2">
                                @if($skillsGrowth >= 0)
                                    <span class="text-success mr-1">
                                        <i class="fas fa-arrow-up"></i> {{ $skillsGrowth }}%
                                    </span>
                                @else
                                    <span class="text-danger mr-1">
                                        <i class="fas fa-arrow-down"></i> {{ abs($skillsGrowth) }}%
                                    </span>
                                @endif
                                <span class="text-muted">dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-primary text-white rounded-circle">
                                <i class="fas fa-code fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent py-2">
                    <a href="{{ route('skills.index') }}" class="text-primary small font-weight-bold">
                        Kelola Skills <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Projects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Projects
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalProjects }}
                            </div>
                            <div class="text-xs mt-2">
                                @if($projectsGrowth >= 0)
                                    <span class="text-success mr-1">
                                        <i class="fas fa-arrow-up"></i> {{ $projectsGrowth }}%
                                    </span>
                                @else
                                    <span class="text-danger mr-1">
                                        <i class="fas fa-arrow-down"></i> {{ abs($projectsGrowth) }}%
                                    </span>
                                @endif
                                <span class="text-muted">dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-success text-white rounded-circle">
                                <i class="fas fa-folder-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent py-2">
                    <a href="{{ route('projects.index') }}" class="text-success small font-weight-bold">
                        Kelola Projects <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Completion Rate Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completion Rate
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $completionRate }}%
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $completionRate }}%"
                                            aria-valuenow="{{ $completionRate }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs mt-2">
                                <span class="text-muted">
                                    {{ $completedProjects }} dari {{ $totalProjects }} project
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-info text-white rounded-circle">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Views Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 hover-lift">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Profile Views
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($profileViews) }}
                            </div>
                            <div class="text-xs mt-2">
                                <span class="text-muted">
                                    <i class="fas fa-eye mr-1"></i>{{ $todayViews }} hari ini
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-warning text-white rounded-circle">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent py-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>Tracking akan aktif setelah implementasi
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8 mb-4">
            <!-- Welcome Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-home mr-2"></i>Selamat Datang di Dashboard Admin
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border-left-primary" role="alert">
                        <h5 class="alert-heading">
                            <i class="fas fa-info-circle mr-2 text-primary"></i>Informasi
                        </h5>
                        <p class="mb-0">
                            Ini adalah halaman utama dashboard Anda. Gunakan menu di sidebar untuk mengelola 
                            <strong>Skills</strong> dan <strong>Projects</strong> portfolio Anda.
                        </p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('skills.index') }}" class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <i class="fas fa-code mr-2"></i>
                            <span>Kelola Skills</span>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('projects.index') }}" class="btn btn-success btn-block d-flex align-items-center justify-content-center">
                                    <i class="fas fa-folder-open"></i>
                                </span>
                                <span class="text">Kelola Projects</span>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('settings') }}" class="btn btn-secondary  d-flex align-items-center justify-content-center">
                                    <i class="fas fa-cog"></i>
                                </span>
                                <span class="text">Settings</span>
                            </a>
                        </div>
                    </div>

                    <!-- Project Status Overview -->
                    <div class="row mt-4">
                        <div class="col-md-4 text-center">
                            <div class="mb-2">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h6 class="text-success font-weight-bold">Completed</h6>
                            <h4 class="font-weight-bold">{{ $completedProjects }}</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2">
                                <i class="fas fa-spinner fa-3x text-primary"></i>
                            </div>
                            <h6 class="text-primary font-weight-bold">Ongoing</h6>
                            <h4 class="font-weight-bold">{{ $ongoingProjects }}</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2">
                                <i class="fas fa-pause-circle fa-3x text-warning"></i>
                            </div>
                            <h6 class="text-warning font-weight-bold">Paused</h6>
                            <h4 class="font-weight-bold">{{ $pausedProjects }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            @if($recentProjects && $recentProjects->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-folder mr-2"></i>Recent Projects
                    </h6>
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Project</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="15%" class="text-center">Tanggal</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProjects as $index => $project)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($project->image)
                                                <img src="{{ asset('storage/' . $project->image) }}" 
                                                     class="rounded mr-3" 
                                                     width="50" 
                                                     height="50"
                                                     style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded mr-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $project->title }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($project->description, 60) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($project->status == 'completed')
                                            <span class="badge badge-success badge-pill px-3 py-2">
                                                <i class="fas fa-check-circle mr-1"></i>Completed
                                            </span>
                                        @elseif($project->status == 'ongoing')
                                            <span class="badge badge-primary badge-pill px-3 py-2">
                                                <i class="fas fa-spinner mr-1"></i>Ongoing
                                            </span>
                                        @else
                                            <span class="badge badge-warning badge-pill px-3 py-2">
                                                <i class="fas fa-pause-circle mr-1"></i>Paused
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ $project->created_at->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('projects.index') }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Project</h5>
                    <p class="text-muted">Mulai tambahkan project pertama Anda!</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Project
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Top Skills -->
            @if($topSkills && $topSkills->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-star mr-2"></i>Top Skills
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($topSkills as $skill)
                    <h4 class="small font-weight-bold">
                        {{ $skill->name }}
                        <span class="float-right">{{ $skill->level }}%</span>
                    </h4>
                    <div class="progress mb-4" style="height: 10px;">
                        <div class="progress-bar 
                            @if($skill->level >= 80) bg-success
                            @elseif($skill->level >= 60) bg-info
                            @elseif($skill->level >= 40) bg-warning
                            @else bg-danger
                            @endif" 
                            role="progressbar" 
                            style="width: {{ $skill->level }}%"
                            aria-valuenow="{{ $skill->level }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>
                    @endforeach
                    
                    <a href="{{ route('skills.index') }}" class="btn btn-primary btn-block mt-3">
                        <i class="fas fa-th mr-2"></i>Lihat Semua Skills
                    </a>
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <i class="fas fa-code fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Belum Ada Skill</h6>
                    <p class="small text-muted">Tambahkan skill pertama Anda</p>
                    <a href="{{ route('skills.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i>Tambah Skill
                    </a>
                </div>
            </div>
            @endif

            <!-- Skills Distribution -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie mr-2"></i>Skills Distribution
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-success">
                                <i class="fas fa-circle mr-2"></i>Expert (80-100%)
                            </span>
                            <strong>{{ $skillDistribution['expert'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-info">
                                <i class="fas fa-circle mr-2"></i>Advanced (60-79%)
                            </span>
                            <strong>{{ $skillDistribution['advanced'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-warning">
                                <i class="fas fa-circle mr-2"></i>Intermediate (40-59%)
                            </span>
                            <strong>{{ $skillDistribution['intermediate'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-danger">
                                <i class="fas fa-circle mr-2"></i>Beginner (< 40%)
                            </span>
                            <strong>{{ $skillDistribution['beginner'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-server mr-2"></i>System Info
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p class="mb-2">
                            <i class="fas fa-circle text-success mr-2"></i>
                            <strong>Laravel:</strong> {{ app()->version() }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-circle text-success mr-2"></i>
                            <strong>PHP:</strong> {{ phpversion() }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-circle text-success mr-2"></i>
                            <strong>Database:</strong> {{ config('database.default') }}
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-circle text-success mr-2"></i>
                            <strong>Last Activity:</strong> {{ now()->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .icon-shape {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df!important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a!important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc!important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e!important;
    }
    .progress-sm {
        height: 0.5rem;
    }
    .badge-pill {
        border-radius: 10rem;
        font-size: 0.75rem;
    }

    
</style>
@endpush