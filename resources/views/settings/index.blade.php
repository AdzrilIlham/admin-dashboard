@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Settings</h1>
</div>

<div class="row">
    <!-- General Settings -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                               id="site_name" name="site_name" 
                               value="{{ old('site_name', $settings['site_name'] ?? 'My Portfolio') }}">
                        @error('site_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="site_description">Site Description</label>
                        <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                  id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                        @error('site_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" name="contact_email" 
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" 
                               value="{{ old('phone', $settings['phone'] ?? '') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Social Media Links -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Social Media Links</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.social.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="github_url">
                            <i class="fab fa-github"></i> GitHub URL
                        </label>
                        <input type="url" class="form-control" id="github_url" name="github_url" 
                               value="{{ old('github_url', $settings['github_url'] ?? '') }}"
                               placeholder="https://github.com/username">
                    </div>

                    <div class="form-group">
                        <label for="linkedin_url">
                            <i class="fab fa-linkedin"></i> LinkedIn URL
                        </label>
                        <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                               value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                               placeholder="https://linkedin.com/in/username">
                    </div>

                    <div class="form-group">
                        <label for="twitter_url">
                            <i class="fab fa-twitter"></i> Twitter/X URL
                        </label>
                        <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                               value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}"
                               placeholder="https://twitter.com/username">
                    </div>

                    <div class="form-group">
                        <label for="instagram_url">
                            <i class="fab fa-instagram"></i> Instagram URL
                        </label>
                        <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                               value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                               placeholder="https://instagram.com/username">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Social Links
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- About Me Section -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">About Me</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.about.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="about_me">About Me Content</label>
                        <textarea class="form-control" id="about_me" name="about_me" rows="8">{{ old('about_me', $settings['about_me'] ?? '') }}</textarea>
                        <small class="form-text text-muted">This will be displayed on your portfolio homepage.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save About Me
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection