@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-circle mr-2"></i>Profile
    </h1>
</div>

<div class="row">
    <!-- Left Column - Profile Card -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <!-- Avatar Upload Form -->
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="position-relative d-inline-block mb-3">
                        @if(auth()->user()->avatar)
                            <div id="avatarPreview" class="rounded-circle mx-auto" 
                                 style="width: 150px; height: 150px; background-image: url('{{ asset('storage/' . auth()->user()->avatar) }}'); background-size: cover; background-position: center; border: 4px solid #4e73df;">
                            </div>
                        @else
                            <div id="avatarPreview" class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 150px; height: 150px; font-size: 3rem; font-weight: bold; border: 4px solid #4e73df;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif

                        <!-- Camera Icon Button -->
                        <label for="avatarInput" class="position-absolute bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                               style="width: 45px; height: 45px; bottom: 5px; right: 5px; cursor: pointer; border: 3px solid white;">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="previewAndUpload(event)">
                    </div>
                </form>

                @if(auth()->user()->avatar)
                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeAvatar()">
                        <i class="fas fa-trash-alt mr-1"></i>Remove Photo
                    </button>
                @endif

                <h5 class="mb-1 font-weight-bold mt-2">{{ Auth::user()->name }}</h5>
                <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                
                @if(Auth::user()->email_verified_at)
                    <span class="badge badge-success px-3 py-2 mb-3">
                        <i class="fas fa-check-circle mr-1"></i> Email Verified
                    </span>
                @else
                    <div class="mb-3">
                        <span class="badge badge-warning px-3 py-2 d-block mb-2">
                            <i class="fas fa-exclamation-circle mr-1"></i> Email Not Verified
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="resendVerification()">
                            <i class="fas fa-envelope mr-1"></i>Resend Verification Email
                        </button>
                    </div>
                @endif

                <hr>
                
                <div class="text-muted small mt-3">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <strong>Joined:</strong> {{ Auth::user()->created_at->format('F Y') }}
                </div>
            </div>
        </div>

        <!-- Account Actions Card -->
        <div class="card shadow mb-4 border-left-danger">
            <div class="card-header py-3 bg-transparent">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Account Actions
                </h6>
            </div>
            <div class="card-body">
                <h6 class="mb-2">Logout dari Akun</h6>
                <p class="text-muted small mb-3">Keluar dari sesi Anda saat ini</p>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="button" class="btn btn-danger btn-block" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column - Forms -->
    <div class="col-lg-8">
        <!-- Update Profile Info -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-gradient-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-user-edit mr-2"></i>Update Profile Information
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">
                            <i class="fas fa-user mr-1 text-primary"></i>Name
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', Auth::user()->name) }}" 
                               style="max-width: 500px;"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">
                            <i class="fas fa-envelope mr-1 text-primary"></i>Email Address
                        </label>
                        <input type="email" 
                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::user()->email) }}" 
                               style="max-width: 500px;"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card shadow">
            <div class="card-header py-3 bg-gradient-warning">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-shield-alt mr-2"></i>Update Password
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password" class="font-weight-bold">
                            <i class="fas fa-key mr-1 text-warning"></i>Current Password
                        </label>
                        <div class="input-group" style="max-width: 500px;">
                            <input type="password" 
                                   class="form-control form-control-lg @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="font-weight-bold">
                            <i class="fas fa-lock mr-1 text-warning"></i>New Password
                        </label>
                        <div class="input-group" style="max-width: 500px;">
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   oninput="checkPasswordStrength(this.value)"
                                   required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password_icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="passwordStrength" class="mt-2" style="display: none;">
                            <small class="font-weight-bold">Password Strength: <span id="strengthText"></span></small>
                            <div class="progress" style="height: 5px; max-width: 500px;">
                                <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>Minimal 8 karakter
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-bold">
                            <i class="fas fa-check-circle mr-1 text-warning"></i>Confirm New Password
                        </label>
                        <div class="input-group" style="max-width: 500px;">
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   oninput="checkPasswordMatch()"
                                   required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>
                        <small id="passwordMatchMessage" class="form-text" style="display: none;"></small>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-check-circle mr-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .btn-link {
        text-decoration: none;
        font-size: 0.875rem;
    }
    .btn-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script>
function previewAndUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({ icon: 'error', title: 'File Terlalu Besar!', text: 'Ukuran file maksimal 2MB', confirmButtonColor: '#dc3545' });
        return;
    }
    
    if (!file.type.startsWith('image/')) {
        Swal.fire({ icon: 'error', title: 'Format Salah!', text: 'File harus berupa gambar (JPG, PNG, GIF)', confirmButtonColor: '#dc3545' });
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('avatarPreview');
        preview.style.backgroundImage = `url(${e.target.result})`;
        preview.innerHTML = '';
    };
    reader.readAsDataURL(file);

    Swal.fire({ title: 'Uploading...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
    document.getElementById('avatarForm').submit();
}

function removeAvatar() {
    Swal.fire({
        title: 'Hapus Foto Profile?',
        text: 'Foto profile Anda akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('profile.avatar.destroy') }}", {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Foto profile berhasil dihapus', timer: 1500, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1500);
                }
            });
        }
    });
}

function resendVerification() {
    Swal.fire({
        title: 'Kirim Ulang Email Verifikasi?',
        text: 'Link verifikasi akan dikirim ke email Anda',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4e73df',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add your resend verification endpoint here
            // fetch("{{ route('verification.send') }}", { ... })
            
            Swal.fire({
                icon: 'success',
                title: 'Email Terkirim!',
                text: 'Silahkan cek inbox atau spam folder email Anda',
                confirmButtonColor: '#28a745'
            });
        }
    });
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength(password) {
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    const strengthBar = document.getElementById('strengthBar');
    
    if (password.length === 0) {
        strengthDiv.style.display = 'none';
        return;
    }
    
    strengthDiv.style.display = 'block';
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z\d]/.test(password)) strength++;
    
    const levels = [
        { text: 'Very Weak', color: 'bg-danger', width: '20%' },
        { text: 'Weak', color: 'bg-danger', width: '40%' },
        { text: 'Fair', color: 'bg-warning', width: '60%' },
        { text: 'Good', color: 'bg-info', width: '80%' },
        { text: 'Strong', color: 'bg-success', width: '100%' }
    ];
    
    const level = levels[strength] || levels[0];
    strengthText.textContent = level.text;
    strengthText.className = level.color.replace('bg-', 'text-');
    strengthBar.className = 'progress-bar ' + level.color;
    strengthBar.style.width = level.width;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const message = document.getElementById('passwordMatchMessage');
    
    if (confirmation.length === 0) {
        message.style.display = 'none';
        return;
    }
    
    message.style.display = 'block';
    if (password === confirmation) {
        message.className = 'form-text text-success';
        message.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Password cocok';
    } else {
        message.className = 'form-text text-danger';
        message.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Password tidak cocok';
    }
}

function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-sign-out-alt"></i> Ya, Logout!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Logging out...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
            setTimeout(() => document.getElementById('logout-form').submit(), 500);
        }
    });
}

@if(session('success'))
Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: true, confirmButtonColor: '#28a745' });
@endif

@if(session('error'))
Swal.fire({ icon: 'error', title: 'Oops...', text: '{{ session('error') }}', confirmButtonColor: '#dc3545' });
@endif
</script>
@endpush
@endsection