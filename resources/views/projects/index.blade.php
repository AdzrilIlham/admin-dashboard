@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Project</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Tambah Project</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Link</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->status }}</td>
                    <td>
                        @if ($project->link)
                            <a href="{{ $project->link }}" target="_blank">Kunjungi</a>
                        @endif
                    </td>
                    <td>
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="gambar" width="100">
                        @else
                            <span>Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada project</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
