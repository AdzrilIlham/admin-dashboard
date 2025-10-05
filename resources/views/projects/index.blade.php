@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Daftar Project</h1>

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

    <!-- Tombol Tambah Project dengan Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProjectModal">
        <i class="fas fa-plus me-2"></i>Tambah Project
    </button>

    <!-- Modal Tambah Project -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Tambah Project Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="project_title" class="form-label">Judul Project <span class="text-danger">*</span></label>
                        <input type="text" 
                               id="project_title" 
                               name="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}"
                               placeholder="Contoh: Aplikasi E-Commerce"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="project_description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="project_description" 
                                  name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Jelaskan tentang project ini..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="project_status" 
                                        name="status" 
                                        class="form-select @error('status') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_link" class="form-label">Link Project (Opsional)</label>
                                <input type="url" 
                                       id="project_link" 
                                       name="link" 
                                       class="form-control @error('link') is-invalid @enderror" 
                                       value="{{ old('link') }}"
                                       placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="project_image" class="form-label">Gambar Project (Opsional)</label>
                        <input type="file" 
                               id="project_image" 
                               name="image" 
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*"
                               onchange="previewImage(event, 'add_preview')">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        <div id="add_preview" class="mt-2"></div>
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

    <!-- Modal Edit Project -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editProjectForm" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_project_title" class="form-label">Judul Project <span class="text-danger">*</span></label>
                        <input type="text" 
                               id="edit_project_title" 
                               name="title" 
                               class="form-control" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_project_description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="edit_project_description" 
                                  name="description" 
                                  class="form-control" 
                                  rows="4"
                                  required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_project_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="edit_project_status" 
                                        name="status" 
                                        class="form-select" 
                                        required>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                    <option value="paused">Paused</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_project_link" class="form-label">Link Project</label>
                                <input type="url" 
                                       id="edit_project_link" 
                                       name="link" 
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_project_image" class="form-label">Gambar Project</label>
                        <input type="file" 
                               id="edit_project_image" 
                               name="image" 
                               class="form-control"
                               accept="image/*"
                               onchange="previewImage(event, 'edit_preview')">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        <div id="edit_preview" class="mt-2"></div>
                        <input type="hidden" id="edit_current_image" name="current_image">
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

    <!-- Tabel Projects -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="20%">Judul</th>
                            <th width="30%">Deskripsi</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Link</th>
                            <th width="10%" class="text-center">Gambar</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $index => $project)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $project->title }}</strong></td>
                            <td>{{ Str::limit($project->description, 80) }}</td>
                            <td class="text-center">
                                @if($project->status == 'completed')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Completed</span>
                                @elseif($project->status == 'ongoing')
                                    <span class="badge bg-primary"><i class="fas fa-spinner me-1"></i>Ongoing</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-pause-circle me-1"></i>Paused</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($project->link)
                                    <a href="{{ $project->link }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Kunjungi Project">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" 
                                         alt="{{ $project->title }}" 
                                         class="img-thumbnail cursor-pointer"
                                         width="80"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModal"
                                         onclick="showImageModal('{{ asset('storage/' . $project->image) }}', '{{ $project->title }}')">
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-image"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-warning me-1 edit-project-btn" 
                                        data-id="{{ $project->id }}"
                                        data-title="{{ $project->title }}"
                                        data-description="{{ $project->description }}"
                                        data-status="{{ $project->status }}"
                                        data-link="{{ $project->link }}"
                                        data-image="{{ $project->image }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editProjectModal"
                                        title="Edit project">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('projects.destroy', $project) }}" 
                                      method="POST" 
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Hapus project">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada project. Klik tombol "Tambah Project" untuk menambahkan project baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($projects, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal untuk menampilkan gambar besar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .cursor-pointer:hover {
        transform: scale(1.05);
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }
</style>
@endpush

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

    // Preview image before upload
    function previewImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Handle edit button click
    document.querySelectorAll('.edit-project-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const description = this.dataset.description;
            const status = this.dataset.status;
            const link = this.dataset.link;
            const image = this.dataset.image;
            
            // Update form action URL
            const form = document.getElementById('editProjectForm');
            form.action = `/projects/${id}`;
            
            // Fill form fields
            document.getElementById('edit_project_title').value = title;
            document.getElementById('edit_project_description').value = description;
            document.getElementById('edit_project_status').value = status;
            document.getElementById('edit_project_link').value = link || '';
            document.getElementById('edit_current_image').value = image || '';
            
            // Show current image if exists
            const preview = document.getElementById('edit_preview');
            preview.innerHTML = '';
            if (image) {
                const img = document.createElement('img');
                img.src = `/storage/${image}`;
                img.className = 'img-thumbnail mt-2';
                img.style.maxWidth = '200px';
                const label = document.createElement('small');
                label.className = 'd-block text-muted mt-1';
                label.textContent = 'Gambar saat ini:';
                preview.appendChild(label);
                preview.appendChild(img);
            }
        });
    });

    // Show image in modal
    function showImageModal(imageSrc, imageTitle) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModalLabel').textContent = imageTitle;
    }

    // Confirm delete
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Apakah Anda yakin ingin menghapus project ini? Tindakan ini tidak dapat dibatalkan.')) {
                this.submit();
            }
        });
    });

    // Re-open modal if there are validation errors
    @if($errors->any())
        const addModal = new bootstrap.Modal(document.getElementById('addProjectModal'));
        addModal.show();
    @endif
</script>
@endpush