@extends('layouts.public')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">About Me</h1>
    <div id="about-content" class="text-center">
        <p>Loading about me data...</p>
    </div>
</div>

<script>
fetch('/api/portfolio/about')
    .then(res => res.json())
    .then(data => {
        const c = document.getElementById('about-content');
        if (data.success) {
            const a = data.data;
            c.innerHTML = `
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <img src="${a.profile_image ?? 'https://via.placeholder.com/200'}" class="rounded-circle img-fluid shadow" alt="Profile Image">
                    </div>
                    <div class="col-md-8 text-start">
                        <h2>${a.title}</h2>
                        <h5 class="text-muted">${a.subtitle ?? ''}</h5>
                        <p class="mt-3">${a.description}</p>
                        <p><strong>Email:</strong> ${a.email}</p>
                        <p><strong>Phone:</strong> ${a.phone ?? '-'}</p>
                        <p><strong>Location:</strong> ${a.location ?? '-'}</p>
                        <p><strong>Years of Experience:</strong> ${a.years_of_experience ?? 0}</p>
                        <div class="mt-3">
                            ${a.github_url ? `<a href="${a.github_url}" target="_blank" class="btn btn-dark me-2">GitHub</a>` : ''}
                            ${a.linkedin_url ? `<a href="${a.linkedin_url}" target="_blank" class="btn btn-primary me-2">LinkedIn</a>` : ''}
                            ${a.instagram_url ? `<a href="${a.instagram_url}" target="_blank" class="btn btn-danger">Instagram</a>` : ''}
                        </div>
                    </div>
                </div>
            `;
        } else {
            c.innerHTML = "<p>About Me data not found.</p>";
        }
    })
    .catch(() => {
        document.getElementById('about-content').innerHTML = "<p>Error loading data.</p>";
    });
</script>
@endsection
