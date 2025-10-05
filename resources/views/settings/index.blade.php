@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Settings</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- General Settings --}}
    <div class="card mb-4">
        <div class="card-header">General Settings</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" class="form-control" id="site_name" name="site_name"
                           value="{{ old('site_name', $settings['site_name']) }}">
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">Site Description</label>
                    <textarea class="form-control" id="site_description" name="site_description">{{ old('site_description', $settings['site_description']) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                           value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           value="{{ old('phone', $settings['phone']) }}">
                </div>

                <button type="submit" class="btn btn-primary">Save General Settings</button>
            </form>
        </div>
    </div>

    {{-- Social Media Settings --}}
    <div class="card mb-4">
        <div class="card-header">Social Media Links</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.social.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="github_url" class="form-label">GitHub URL</label>
                    <input type="url" class="form-control" id="github_url" name="github_url"
                           value="{{ old('github_url', $settings['github_url']) }}">
                </div>

                <div class="mb-3">
                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url"
                           value="{{ old('linkedin_url', $settings['linkedin_url']) }}">
                </div>

                <div class="mb-3">
                    <label for="twitter_url" class="form-label">Twitter URL</label>
                    <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                           value="{{ old('twitter_url', $settings['twitter_url']) }}">
                </div>

                <div class="mb-3">
                    <label for="instagram_url" class="form-label">Instagram URL</label>
                    <input type="url" class="form-control" id="instagram_url" name="instagram_url"
                           value="{{ old('instagram_url', $settings['instagram_url']) }}">
                </div>

                <button type="submit" class="btn btn-primary">Save Social Media Links</button>
            </form>
        </div>
    </div>

    {{-- About Me --}}
    <div class="card mb-4">
        <div class="card-header">About Me</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.about.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="about_me" class="form-label">About Me</label>
                    <textarea class="form-control" id="about_me" name="about_me">{{ old('about_me', $settings['about_me']) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save About Me</button>
            </form>
        </div>
    </div>

    {{-- Dark Mode Toggle --}}
    <div class="card mb-4">
        <div class="card-header">Appearance</div>
        <div class="card-body">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="dark_mode" name="dark_mode"
                       {{ isset($settings['dark_mode']) && $settings['dark_mode'] ? 'checked' : '' }}>
                <label class="form-check-label" for="dark_mode">Enable Dark Mode</label>
            </div>
        </div>
    </div>
</div>

{{-- Dark Mode CSS --}}
<style>
body {
    background-color: #fff;
    color: #000;
}

.dark body {
    background-color: #121212 !important;
    color: #fff !important;
}

.dark .card {
    background-color: #1e1e1e !important;
    color: #fff !important;
}

.dark .form-control {
    background-color: #2c2c2c !important;
    color: #fff !important;
    border-color: #555 !important;
}

.dark .btn-primary {
    background-color: #3a76f0 !important;
    border-color: #3a76f0 !important;
    color: #fff !important;
}

.dark .alert-success {
    background-color: #2e7d32 !important;
    color: #fff !important;
}
</style>

{{-- Dark Mode JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('dark_mode');

    // Load dari localStorage
    if (localStorage.getItem('dark-mode') === 'true') {
        document.documentElement.classList.add('dark');
        checkbox.checked = true;
    }

    // Toggle live
    checkbox.addEventListener('change', function() {
        document.documentElement.classList.toggle('dark', this.checked);
        localStorage.setItem('dark-mode', this.checked);
    });
});
</script>
@endsection
