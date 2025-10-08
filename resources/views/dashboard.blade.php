@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
        </h1>
        <span class="text-muted small">
            <i class="far fa-calendar-alt mr-1"></i>{{ now()->format('l, d F Y') }}
        </span>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row mb-3">
        <!-- Total Skills Card -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2 hover-lift">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Skills</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSkills }}</div>
                            <div class="text-xs mt-1">
                                <span class="text-success mr-1"><i class="fas fa-arrow-up"></i> {{ $skillsGrowth }}%</span>
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
            </div>
        </div>

        <!-- Total Projects Card -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2 hover-lift">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProjects }}</div>
                            <div class="text-xs mt-1">
                                <span class="text-success mr-1"><i class="fas fa-arrow-up"></i> {{ $projectsGrowth }}%</span>
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
            </div>
        </div>

        <!-- Completion Rate Card -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow-sm h-100 py-2 hover-lift">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completion Rate</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $completionRate }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs mt-1">
                                <span class="text-muted">{{ $completedProjects }} dari {{ $totalProjects }} project</span>
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
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2 hover-lift">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Profile Views</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($profileViews) }}</div>
                            <div class="text-xs mt-1">
                                <span class="text-muted"><i class="fas fa-eye mr-1"></i>{{ $todayViews }} hari ini</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-warning text-white rounded-circle">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-7 mb-3">
            <!-- Welcome Banner -->
            <div class="card shadow-sm mb-3 bg-gradient-primary text-white overflow-hidden">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-white mb-1">
                                <i class="fas fa-hand-sparkles mr-2"></i>
                                @php
                                    $hour = date('H');
                                    if($hour < 12) echo 'Good Morning';
                                    elseif($hour < 18) echo 'Good Afternoon';
                                    else echo 'Good Evening';
                                @endphp
                            </h6>
                            <h5 class="text-white font-weight-bold mb-1">Admin!</h5>
                            <p class="text-white-50 mb-0 small">Keep building amazing things!</p>
                        </div>
                        <div class="col-4 text-right">
                            <i class="fas fa-rocket fa-3x" style="opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Status Mini Cards -->
            <div class="row mb-3">
                <div class="col-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-2 text-center">
                            <div class="rounded-circle bg-success-soft d-inline-flex align-items-center justify-content-center mb-1" style="width:40px; height:40px;">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="small text-muted mb-0">Completed</div>
                            <h5 class="font-weight-bold mb-0">{{ $completedProjects }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-2 text-center">
                            <div class="rounded-circle bg-primary-soft d-inline-flex align-items-center justify-content-center mb-1" style="width:40px; height:40px;">
                                <i class="fas fa-spinner text-primary"></i>
                            </div>
                            <div class="small text-muted mb-0">Ongoing</div>
                            <h5 class="font-weight-bold mb-0">{{ $ongoingProjects }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-2 text-center">
                            <div class="rounded-circle bg-warning-soft d-inline-flex align-items-center justify-content-center mb-1" style="width:40px; height:40px;">
                                <i class="fas fa-pause-circle text-warning"></i>
                            </div>
                            <div class="small text-muted mb-0">Paused</div>
                            <h5 class="font-weight-bold mb-0">{{ $pausedProjects }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            @if($recentProjects && $recentProjects->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-folder mr-2"></i>Recent Projects</h6>
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-2 px-3 small">Project</th>
                                    <th class="border-0 py-2 text-center small">Status</th>
                                    <th class="border-0 py-2 text-center small">Tanggal</th>
                                    <th class="border-0 py-2 text-center small">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProjects->take(3) as $project)
                                <tr>
                                    <td class="px-3 py-2">
                                        <div class="d-flex align-items-center">
                                            @if($project->image)
                                                <img src="{{ asset('storage/' . $project->image) }}" class="rounded mr-2" width="35" height="35" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded mr-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-image text-muted small"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold small">{{ Str::limit($project->title, 25) }}</div>
                                                <small class="text-muted">{{ Str::limit($project->description, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center py-2">
                                        @if($project->status == 'completed')
                                            <span class="badge badge-success badge-sm">Completed</span>
                                        @elseif($project->status == 'ongoing')
                                            <span class="badge badge-primary badge-sm">Ongoing</span>
                                        @else
                                            <span class="badge badge-warning badge-sm">Paused</span>
                                        @endif
                                    </td>
                                    <td class="text-center py-2">
                                        <small class="text-muted">{{ $project->created_at->format('d M') }}</small>
                                    </td>
                                    <td class="text-center py-2">
                                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary btn-sm-custom">
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
            <div class="card shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                    <h6 class="text-muted">Belum Ada Project</h6>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-plus mr-1"></i>Tambah Project
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-5">
            <!-- Project Chart -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white py-2">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie mr-2"></i>Project Status</h6>
                </div>
                <div class="card-body p-2" style="height: 200px;">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>

            <!-- Top Skills -->
            @if($topSkills && $topSkills->count() > 0)
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white py-2">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-star mr-2"></i>Top Skills</h6>
                </div>
                <div class="card-body p-3">
                    @foreach($topSkills->take(4) as $skill)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="font-weight-bold">{{ $skill->name }}</small>
                            <small class="text-muted">{{ $skill->level }}%</small>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar 
                                @if($skill->level >= 80) bg-success
                                @elseif($skill->level >= 60) bg-info
                                @elseif($skill->level >= 40) bg-warning
                                @else bg-danger
                                @endif" 
                                style="width: {{ $skill->level }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('skills.index') }}" class="btn btn-primary btn-sm btn-block mt-2">
                        <i class="fas fa-th mr-1"></i>Lihat Semua Skills
                    </a>
                </div>
            </div>
            @endif

            <!-- Skills Distribution -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white py-2">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-layer-group mr-2"></i>Skills Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1 py-1">
                        <span class="small"><i class="fas fa-circle text-success mr-2"></i>Expert</span>
                        <strong>{{ $skillDistribution['expert'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1 py-1">
                        <span class="small"><i class="fas fa-circle text-info mr-2"></i>Advanced</span>
                        <strong>{{ $skillDistribution['advanced'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1 py-1">
                        <span class="small"><i class="fas fa-circle text-warning mr-2"></i>Intermediate</span>
                        <strong>{{ $skillDistribution['intermediate'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <span class="small"><i class="fas fa-circle text-danger mr-2"></i>Beginner</span>
                        <strong>{{ $skillDistribution['beginner'] }}</strong>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white py-2">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bolt mr-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body p-2">
                    <div class="row no-gutters">
                        <div class="col-6 pr-1 mb-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary btn-block btn-sm py-2">
                                <i class="fas fa-plus-circle d-block mb-1"></i>
                                <span class="small">New Project</span>
                            </a>
                        </div>
                        <div class="col-6 pl-1 mb-2">
                            <a href="{{ route('skills.index') }}" class="btn btn-outline-success btn-block btn-sm py-2">
                                <i class="fas fa-code d-block mb-1"></i>
                                <span class="small">Add Skill</span>
                            </a>
                        </div>
                        <div class="col-6 pr-1">
                            <a href="#" class="btn btn-outline-info btn-block btn-sm py-2">
                                <i class="fas fa-user-edit d-block mb-1"></i>
                                <span class="small">Edit Profile</span>
                            </a>
                        </div>
                        <div class="col-6 pl-1">
                            <a href="{{ route('settings') }}" class="btn btn-outline-secondary btn-block btn-sm py-2">
                                <i class="fas fa-cog d-block mb-1"></i>
                                <span class="small">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-2">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-server mr-2"></i>System</h6>
                </div>
                <div class="card-body p-2">
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1 py-1">
                            <span><strong>Laravel:</strong></span>
                            <span>{{ app()->version() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 py-1">
                            <span><strong>PHP:</strong></span>
                            <span>{{ phpversion() }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span><strong>DB:</strong></span>
                            <span>{{ config('database.default') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Compact Spacing */
    .container-fluid {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .icon-shape {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .border-left-primary { border-left: 0.25rem solid #4e73df!important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a!important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc!important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e!important; }
    
    .progress-sm { height: 0.5rem; }
    
    .bg-success-soft { background-color: rgba(28, 200, 138, 0.1); }
    .bg-primary-soft { background-color: rgba(78, 115, 223, 0.1); }
    .bg-warning-soft { background-color: rgba(246, 194, 62, 0.1); }
    
    .card { 
        border-radius: 0.5rem; 
        margin-bottom: 0 !important;
    }
    
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .btn-sm-custom {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    .badge-sm {
        font-size: 0.65rem;
        padding: 0.3em 0.6em;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .text-white-50 {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Remove excess spacing */
    .row { margin-left: -0.5rem; margin-right: -0.5rem; }
    .row > [class*="col-"] { padding-left: 0.5rem; padding-right: 0.5rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('projectChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Ongoing', 'Paused'],
                datasets: [{
                    data: [{{ $completedProjects }}, {{ $ongoingProjects }}, {{ $pausedProjects }}],
                    backgroundColor: ['#1cc88a', '#4e73df', '#f6c23e'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            font: { size: 10 },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush