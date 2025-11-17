@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Project</h1>
    
    <div class="card shadow">
        <div class="card-body">
            <!-- TAMBAHKAN enctype untuk upload file -->
            <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Input Name (yang sudah ada) -->
                <div class="form-group">
                    <label for="name">Project Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <!-- TARUH KODE ICON & THUMBNAIL DI SINI (dari artifact #4) -->
                <div class="form-group">
                    <label for="icon">Icon (Font Awesome atau URL)</label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                           id="icon" name="icon" value="{{ old('icon', $project->icon ?? '') }}"
                           placeholder="fab fa-laravel atau /images/project-icon.png">
                    <small class="form-text text-muted">
                        Icon kecil untuk thumbnail. Contoh: fab fa-wordpress, fas fa-globe
                    </small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="thumbnail">Project Thumbnail</label>
                    <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" 
                           id="thumbnail" name="thumbnail" accept="image/*">
                    <small class="form-text text-muted">
                        Upload screenshot atau gambar project (Max: 2MB)
                    </small>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Input Description (yang sudah ada) -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                
                <!-- Input Status (yang sudah ada) -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection