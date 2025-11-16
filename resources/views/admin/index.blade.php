@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Portfolios</h2>
    <a href="{{ route('portfolios.create') }}" class="btn btn-primary mb-3">+ Tambah Project</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($portfolios as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ Str::limit($project->description, 50) }}</td>
                    <td><a href="{{ $project->link }}" target="_blank">Lihat</a></td>
                    <td>
                        <a href="{{ route('portfolios.edit', $project->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('portfolios.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
