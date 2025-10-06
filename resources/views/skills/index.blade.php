@extends('layouts.app')
@section('content')
<div class="container-fluid">
<h1 class="h3 mb-4 text-gray-800">Skills</h1>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tombol Tambah Skill dengan Modal -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSkillModal">
    <i class="fas fa-plus me-2"></i>Tambah Skill
</button>

<!-- Modal Tambah Skill -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('skills.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addSkillModalLabel">Tambah Skill Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="skill_name" class="form-label">Nama Skill <span class="text-danger">*</span></label>
                    <input type="text" 
                           id="skill_name" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}"
                           placeholder="Contoh: Laravel, JavaScript, MySQL"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="skill_level" class="form-label">Level (%) <span class="text-danger">*</span></label>
                    <input type="number" 
                           id="skill_level" 
                           name="level" 
                           class="form-control @error('level') is-invalid @enderror" 
                           value="{{ old('level') }}"
                           min="0" 
                           max="100" 
                           placeholder="0-100"
                           required>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Masukkan nilai antara 0-100</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Skill -->
<div class="modal fade" id="editSkillModal" tabindex="-1" aria-labelledby="editSkillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSkillForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editSkillModalLabel">Edit Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit_skill_name" class="form-label">Nama Skill <span class="text-danger">*</span></label>
                    <input type="text" 
                           id="edit_skill_name" 
                           name="name" 
                           class="form-control" 
                           required>
                </div>
                <div class="mb-3">
                    <label for="edit_skill_level" class="form-label">Level (%) <span class="text-danger">*</span></label>
                    <input type="number" 
                           id="edit_skill_level" 
                           name="level" 
                           class="form-control" 
                           min="0" 
                           max="100" 
                           required>
                    <small class="form-text text-muted">Masukkan nilai antara 0-100</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Skills -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="40%">Nama Skill</th>
                        <th width="30%">Level</th>
                        <th width="25%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $index => $skill)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $skill->name }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $skill->level }}%;" 
                                         aria-valuenow="{{ $skill->level }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="badge bg-secondary">{{ $skill->level }}%</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm btn-warning me-1 edit-btn" 
                                    data-id="{{ $skill->id }}"
                                    data-name="{{ $skill->name }}"
                                    data-level="{{ $skill->level }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editSkillModal"
                                    title="Edit skill">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('skills.destroy', $skill->id) }}" 
                                  method="POST" 
                                  class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        title="Hapus skill">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">Belum ada data skill. Klik tombol "Tambah Skill" untuk menambahkan skill baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (jika diperlukan) -->
        @if(method_exists($skills, 'links'))
            <div class="d-flex justify-content-center mt-3">
                {{ $skills->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Skills Distribution Card -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-chart-pie me-2"></i>Skills Distribution
                </h6>
            </div>
            <div class="card-body">
                <div class="distribution-item d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <div>
                        <span class="badge bg-success me-2">●</span>
                        <span class="text-dark">Expert (80-100%)</span>
                    </div>
                    <span class="badge bg-success rounded-pill fs-6">{{ $distribution['expert'] }}</span>
                </div>
                
                <div class="distribution-item d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <div>
                        <span class="badge bg-info me-2">●</span>
                        <span class="text-dark">Advanced (60-79%)</span>
                    </div>
                    <span class="badge bg-info rounded-pill fs-6">{{ $distribution['advanced'] }}</span>
                </div>
                
                <div class="distribution-item d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <div>
                        <span class="badge bg-warning me-2">●</span>
                        <span class="text-dark">Intermediate (40-59%)</span>
                    </div>
                    <span class="badge bg-warning rounded-pill fs-6">{{ $distribution['intermediate'] }}</span>
                </div>
                
                <div class="distribution-item d-flex justify-content-between align-items-center p-2">
                    <div>
                        <span class="badge bg-danger me-2">●</span>
                        <span class="text-dark">Beginner (< 40%)</span>
                    </div>
                    <span class="badge bg-danger rounded-pill fs-6">{{ $distribution['beginner'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const level = this.dataset.level;
            
            // Update form action URL
            const form = document.getElementById('editSkillForm');
            form.action = `/skills/${id}`;
            
            // Fill form fields
            document.getElementById('edit_skill_name').value = name;
            document.getElementById('edit_skill_level').value = level;
        });
    });

    // Confirm delete with SweetAlert2 (optional, jika sudah install)
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Apakah Anda yakin ingin menghapus skill ini? Tindakan ini tidak dapat dibatalkan.')) {
                this.submit();
            }
        });
    });

    // Re-open modal if there are validation errors
    @if($errors->any())
        const addModal = new bootstrap.Modal(document.getElementById('addSkillModal'));
        addModal.show();
    @endif
</script>
@endpush