@extends('layouts.public')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">My Portfolio</h1>
    <div id="portfolio-content" class="row justify-content-center">
        <p>Loading portfolio data...</p>
    </div>
</div>

<script>
fetch('/api/portfolio/projects')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('portfolio-content');
        if (data.success && data.data.length > 0) {
            container.innerHTML = data.data.map(p => `
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">${p.title}</h5>
                            <p class="card-text">${p.description ?? 'No description available.'}</p>
                            <p class="text-muted">Status: <strong>${p.status ?? '-'}</strong></p>
                            ${p.link ? `<a href="${p.link}" target="_blank" class="btn btn-primary">View Project</a>` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = "<p>No projects found.</p>";
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById('portfolio-content').innerHTML = "<p>Error loading data.</p>";
    });
</script>
@endsection
