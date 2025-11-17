@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Create Skill</h1>
    
    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skills.store') }}">
                @csrf
                
                <!-- Input Name (yang sudah ada) -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <!-- TARUH KODE ICON DI SINI (dari artifact #3) -->
                <div class="form-group">
                    <label for="icon">Icon (Font Awesome Class atau URL Gambar)</label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                           id="icon" name="icon" value="{{ old('icon', $skill->icon ?? '') }}"
                           placeholder="Contoh: fab fa-laravel atau /images/laravel-logo.png">
                    <small class="form-text text-muted">
                        Gunakan Font Awesome class (contoh: fab fa-laravel, fab fa-python)
                    </small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Input Proficiency (yang sudah ada) -->
                <div class="form-group">
                    <label for="proficiency">Proficiency Level</label>
                    <select class="form-control" id="proficiency" name="proficiency">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
                
                <!-- Input Description (yang sudah ada) -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection