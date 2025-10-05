@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Settings</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- General Settings Form -->
    <div class="card mb-4">
        <div class="card-header">General Settings</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" class="form-control" id="site_name" name="site_name" 
                           value="{{ old('site_name', $settings['site_name']) }}" required>
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

    <!-- Social Media Settings Form -->
    <div class="card mb-4">
        <div class="card-header">Social Media Links</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.updateSocial') }}">
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

                <button type="submit" class="btn btn-primary">Save Social Links</button>
            </form>
        </div>
    </div>

    <!-- About Me Form -->
    <div class="card mb-4">
        <div class="card-header">About Me</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.updateAbout') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="about_me" class="form-label">About Me</label>
                    <textarea class="form-control" id="about_me" name="about_me" rows="5">{{ old('about_me', $settings['about_me']) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save About Me</button>
            </form>
        </div>
    </div>
</div>
@endsection
