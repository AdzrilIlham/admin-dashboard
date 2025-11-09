@extends('layouts.app')

@section('title', 'Skills Management')

@section('content')
<!-- Page Heading -->
<div class="page-heading">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Skills Management</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSkillModal">
            <i class="fas fa-plus fa-sm me-1"></i> Tambah Skill
        </button>
    </div>

    <!-- Delete Notification -->
    <!-- Success Notification dengan SweetAlert2 -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    });
</script>
@endif

    <!-- Content Row -->
    <div class="row">
        <!-- Skills Table -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Skills</h6>
                    <span class="badge bg-primary">{{ $skills->count() }} Skills</span>
                </div>
                <div class="card-body">
                    @if($skills->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="skillsTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Skill</th>
                                    <th width="30%">Level</th>
                                    <th width="20%">Kategori</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($skills as $skill)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($skill->icon)
                                                <i class="{{ $skill->icon }} me-2 text-primary"></i>
                                            @else
                                                <i class="fas fa-code me-2 text-muted"></i>
                                            @endif
                                            <strong>{{ $skill->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-3" style="height: 20px;">
                                                <div class="progress-bar {{ $skill->getCategoryClass() }}" 
                                                    role="progressbar" 
                                                    style="width: {{ $skill->level }}%; 
                                                            @if($skill->level >= 80)
                                                                background: #6366f1 !important;
                                                            @elseif($skill->level >= 60)
                                                                background: #10b981 !important;
                                                            @elseif($skill->level >= 40)
                                                                background: #0ea5e9 !important;
                                                            @else
                                                                background: #f59e0b !important;
                                                            @endif
                                                            background-image: none !important;" 
                                                    aria-valuenow="{{ $skill->level }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                    <span class="progress-text">{{ $skill->level }}%</span>
                                                </div>
                                            </div>
                                            <small class="text-muted nowrap">{{ $skill->level }}%</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $skill->getCategoryClass() }}">
                                            <i class="fas fa-circle me-1 small"></i>
                                            {{ $skill->getCategoryName() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button" class="btn btn-sm btn-warning edit-skill" 
                                                    data-id="{{ $skill->id }}"
                                                    data-name="{{ $skill->name }}"
                                                    data-level="{{ $skill->level }}"
                                                    title="Edit Skill">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-skill" 
                                                    data-id="{{ $skill->id }}"
                                                    data-name="{{ $skill->name }}"
                                                    title="Hapus Skill">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada skill yang ditambahkan</h5>
                        <p class="text-muted mb-4">Mulai dengan menambahkan skill pertama Anda</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                            <i class="fas fa-plus me-1"></i> Tambah Skill Pertama
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Charts and Stats -->
        <div class="col-xl-4 col-lg-5">
            <!-- Skills Distribution Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Skills Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="skillsPieChart" height="250"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="d-block mb-2">
                            <i class="fas fa-circle text-primary me-1"></i> Expert (80-100%)
                        </span>
                        <span class="d-block mb-2">
                            <i class="fas fa-circle text-success me-1"></i> Advanced (60-79%)
                        </span>
                        <span class="d-block mb-2">
                            <i class="fas fa-circle text-info me-1"></i> Intermediate (40-59%)
                        </span>
                        <span class="d-block mb-2">
                            <i class="fas fa-circle text-warning me-1"></i> Beginner (< 40%)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-primary font-weight-bold h4 mb-1">{{ $skills->count() }}</div>
                                <div class="text-muted small">Total Skills</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-success font-weight-bold h4 mb-1">
                                    {{ $skills->avg('level') ? number_format($skills->avg('level'), 1) : 0 }}%
                                </div>
                                <div class="text-muted small">Rata-rata Level</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-info font-weight-bold h4 mb-1">{{ $expertCount + $advancedCount }}</div>
                                <div class="text-muted small">Advanced+</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3 bg-light">
                                <div class="text-warning font-weight-bold h4 mb-1">{{ $beginnerCount + $intermediateCount }}</div>
                                <div class="text-muted small">Intermediate & Beginner</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Skill Modal -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSkillModalLabel">Tambah Skill Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addSkillForm" action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Skill <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Contoh: Laravel, JavaScript, MySQL" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level: <span id="levelValueDisplay" class="fw-bold text-primary">50%</span></label>
                        <input type="range" class="form-range @error('level') is-invalid @enderror" 
                               id="level" name="level" min="0" max="100" value="{{ old('level', 50) }}">
                        <div class="d-flex justify-content-between text-muted small mt-2">
                            <span><i class="fas fa-star text-warning"></i> Pemula</span>
                            <span><i class="fas fa-crown text-primary"></i> Ahli</span>
                        </div>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Skill Modal -->
<div class="modal fade" id="editSkillModal" tabindex="-1" aria-labelledby="editSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSkillModalLabel">Edit Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSkillForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_skill_id" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Skill <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_level" class="form-label">Level: <span id="edit_levelValueDisplay" class="fw-bold text-primary">50%</span></label>
                        <input type="range" class="form-range" id="edit_level" name="level" min="0" max="100">
                        <div class="d-flex justify-content-between text-muted small mt-2">
                            <span><i class="fas fa-star text-warning"></i> Pemula</span>
                            <span><i class="fas fa-crown text-primary"></i> Ahli</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSkillModal" tabindex="-1" aria-labelledby="deleteSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSkillModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus skill <strong>"<span id="delete_skill_name"></span>"</strong>?</p>
                <p class="text-center text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <form id="deleteSkillForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.progress {
    position: relative;
    background-color: #e9ecef;
    border-radius: 10px;
    overflow: visible;
    height: 24px;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}
.progress-bar {
    position: relative;
    transition: width 0.6s ease;
    font-weight: 600;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.progress-text {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.8rem;
    color: #fff;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    font-weight: 700;
    z-index: 2;
}
.nowrap {
    white-space: nowrap;
}

/* ✅ WARNA SOLID - TANPA GRADIENT */

/* ===== FORCE SOLID COLOR - NO GRADIENT ===== */

/* Expert (80-100%) - Purple */
.progress-bar.bg-primary {
    background: #6366f1 !important;
    background-color: #6366f1 !important;
    background-image: none !important;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
}

/* Advanced (60-79%) - Green */
.progress-bar.bg-success {
    background: #10b981 !important;
    background-color: #10b981 !important;
    background-image: none !important;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

/* Intermediate (40-59%) - Blue */
.progress-bar.bg-info {
    background: #0ea5e9 !important;
    background-color: #0ea5e9 !important;
    background-image: none !important;
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
}

/* Beginner (<40%) - Orange */
.progress-bar.bg-warning {
    background: #f59e0b !important;
    background-color: #f59e0b !important;
    background-image: none !important;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    color: #fff !important;
}
/* Percentage di luar progress bar */
.text-muted.nowrap {
    font-weight: 600;
    color: #6c757d !important;
    font-size: 0.85rem;
}

/* Hover effect */
.progress:hover .progress-bar {
    filter: brightness(1.1);
    transform: scaleY(1.05);
    transition: all 0.3s ease;
}

/* Animation saat load */
@keyframes progressAnimation {
    from {
        width: 0;
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.progress-bar {
    animation: progressAnimation 0.8s ease-out;
}

/* Notification Styles */
.notification-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

.notification-center {
    position: relative;
    z-index: 10000;
}

.notification-alert {
    padding: 20px 30px;
    font-size: 18px;
    font-weight: 500;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
    min-width: 300px;
    text-align: center;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes fadeOut {
    from { 
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to { 
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
}

/* Dark mode styles */
body.dark-mode .progress {
    background-color: #2d2d44;
}
body.dark-mode .table {
    background-color: #1a1a2e;
    color: #e0e0e0;
}
body.dark-mode .table thead th {
    background-color: #16213e;
    color: #e0e0e0;
    border-color: #2d2d44;
}
body.dark-mode .card {
    background-color: #1a1a2e;
    border-color: #2d2d44;
}
body.dark-mode .card-header {
    background-color: #16213e;
    border-bottom-color: #2d2d44;
}
body.dark-mode .bg-light {
    background-color: #16213e !important;
    border-color: #2d2d44 !important;
}

</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Auto-hide notification after 2 seconds
    const notification = document.querySelector('.notification-overlay');
    if (notification) {
        setTimeout(() => {
            notification.style.display = 'none';
        }, 2000);
    }

    // Add Skill Modal - Level Slider dengan warna real-time
    const levelSlider = document.getElementById('level');
    const levelValueDisplay = document.getElementById('levelValueDisplay');
    
    if (levelSlider && levelValueDisplay) {
        levelSlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            levelValueDisplay.textContent = value + '%';
            
            // Update color based on level
            if (value >= 80) {
                levelValueDisplay.className = 'fw-bold text-primary';
            } else if (value >= 60) {
                levelValueDisplay.className = 'fw-bold text-success';
            } else if (value >= 40) {
                levelValueDisplay.className = 'fw-bold text-info';
            } else {
                levelValueDisplay.className = 'fw-bold text-warning';
            }
        });
        
        // Initialize value
        const initialValue = parseInt(levelSlider.value);
        levelValueDisplay.textContent = initialValue + '%';
        if (initialValue >= 80) {
            levelValueDisplay.className = 'fw-bold text-primary';
        } else if (initialValue >= 60) {
            levelValueDisplay.className = 'fw-bold text-success';
        } else if (initialValue >= 40) {
            levelValueDisplay.className = 'fw-bold text-info';
        } else {
            levelValueDisplay.className = 'fw-bold text-warning';
        }
    }

    // Edit Skill Modal - Level Slider dengan warna real-time
    const editLevelSlider = document.getElementById('edit_level');
    const editLevelValueDisplay = document.getElementById('edit_levelValueDisplay');
    
    if (editLevelSlider && editLevelValueDisplay) {
        editLevelSlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            editLevelValueDisplay.textContent = value + '%';
            
            // Update color based on level
            if (value >= 80) {
                editLevelValueDisplay.className = 'fw-bold text-primary';
            } else if (value >= 60) {
                editLevelValueDisplay.className = 'fw-bold text-success';
            } else if (value >= 40) {
                editLevelValueDisplay.className = 'fw-bold text-info';
            } else {
                editLevelValueDisplay.className = 'fw-bold text-warning';
            }
        });
    }

    // Edit skill functionality
    const editButtons = document.querySelectorAll('.edit-skill');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const level = this.getAttribute('data-level');

            document.getElementById('edit_skill_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_level').value = level;
            
            // Update display dengan warna yang sesuai
            const levelValue = parseInt(level);
            editLevelValueDisplay.textContent = level + '%';
            
            if (levelValue >= 80) {
                editLevelValueDisplay.className = 'fw-bold text-primary';
            } else if (levelValue >= 60) {
                editLevelValueDisplay.className = 'fw-bold text-success';
            } else if (levelValue >= 40) {
                editLevelValueDisplay.className = 'fw-bold text-info';
            } else {
                editLevelValueDisplay.className = 'fw-bold text-warning';
            }

            // Set form action
            document.getElementById('editSkillForm').action = `/admin/skills/${id}`;

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editSkillModal'));
            editModal.show();
        });
    });

    // Delete skill functionality
    const deleteButtons = document.querySelectorAll('.delete-skill');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete_skill_name').textContent = name;
            document.getElementById('deleteSkillForm').action = `/admin/skills/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteSkillModal'));
            deleteModal.show();
        });
    });

    // Skills Chart
    const ctx = document.getElementById('skillsPieChart');
    if (ctx) {
        const skillsPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Expert', 'Advanced', 'Intermediate', 'Beginner'],
                datasets: [{
                    data: [
                        {{ $expertCount }}, 
                        {{ $advancedCount }}, 
                        {{ $intermediateCount }}, 
                        {{ $beginnerCount }}
                    ],
                    backgroundColor: [
                        '#4e73df', // Expert - Blue
                        '#1cc88a', // Advanced - Green
                        '#36b9cc', // Intermediate - Cyan
                        '#f6c23e'  // Beginner - Yellow
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9',
                        '#17a673', 
                        '#2c9faf',
                        '#dda20a'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} skill (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%',
            },
        });
    }

    // Form validation and loading states
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
            }
        });
    });

    // Auto-focus on modal show
    const addSkillModal = document.getElementById('addSkillModal');
    if (addSkillModal) {
        addSkillModal.addEventListener('shown.bs.modal', function () {
            document.getElementById('name').focus();
        });
    }

    const editSkillModal = document.getElementById('editSkillModal');
    if (editSkillModal) {
        editSkillModal.addEventListener('shown.bs.modal', function () {
            document.getElementById('edit_name').focus();
        });
    }
});
</script>
@endpush