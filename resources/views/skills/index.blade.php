@extends('layouts.app') {{-- sesuaikan dengan layout projectmu --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Skill</h1>

    @if(session('success'))
        <div style="background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('skills.create') }}" style="display:inline-block; padding:8px 15px; background:#4CAF50; color:white; border-radius:5px; text-decoration:none;">+ Tambah Skill</a>

    <table border="1" cellpadding="8" cellspacing="0" width="100%" style="margin-top:20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Skill</th>
                <th>Level (%)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skills as $skill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $skill->name }}</td>
                    <td>{{ $skill->level }}</td>
                    <td>
                        <a href="{{ route('skills.edit', $skill->id) }}">Edit</a> |
                        <form action="{{ route('skills.destroy', $skill->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin hapus skill ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada skill</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
