@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Project</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada masalah dengan inputmu.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- ini untuk method update --}}

        <div class="form-group mb-3">
            <label>Judul Project</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="ongoing" {{ $project->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Link Project</label>
            <input type="url" name="link" class="form-control" value="{{ old('link', $project->link) }}">
        </div>

        <div class="form-group mb-3">
            <label>Gambar</label><br>
            @if($project->image)
                <img src="{{ asset('storage/'.$project->image) }}" alt="" width="120" class="mb-2"><br>
            @endif
            <input type="file" name="image" class="form-control">
            <small>Kosongkan jika tidak ingin mengganti gambar</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
