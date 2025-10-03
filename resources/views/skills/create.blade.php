@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama Skill</label>
            <input type="text" name="name" required>
        </div>

        <div style="margin-top:10px;">
            <label>Level (%)</label>
            <input type="number" name="level" min="0" max="100" required>
        </div>

        <button type="submit" style="margin-top:15px; padding:6px 12px;">Simpan</button>
    </form>

    <div style="margin-top:15px;">
        <a href="{{ route('skills.index') }}">Kembali</a>
    </div>
</div>
@endsection
