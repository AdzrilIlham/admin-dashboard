@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profil Saya</h2>

    {{-- Form Update Profil --}}
    <form action="{{ route('profile.update') }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <hr>

    {{-- Form Ubah Password --}}
    <h4>Ubah Password</h4>
    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Ubah Password</button>
    </form>

    <hr>

    {{-- Avatar (upload) --}}
    <h4>Foto Profil</h4>
    <div class="mb-3">
        @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" style="max-width:150px; display:block; margin-bottom:10px;">
        @endif

        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <input type="file" name="avatar" accept="image/*" required>
            </div>
            <button class="btn btn-secondary" type="submit">Unggah Foto</button>
        </form>

        @if ($user->avatar)
            <form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" style="margin-top:8px;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Hapus Foto</button>
            </form>
        @endif
    </div>

    {{-- Notifications --}}
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
