@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">My Portfolio</h1>
    <div id="portfolio-content" class="text-center">
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
                <div class="border p-3 mb-3 rounded shadow-sm">
                    <h3>${p.title}</h3>
                    <p>${p.description}</p>
                    <p>Status: <strong>${p.status}</strong></p>
                    ${p.link ? `<a href="${p.link}" target="_blank">View Project</a>` : ''}
                </div>
            `).join('');
        } else {
            container.innerHTML = "<p>No projects found.</p>";
        }
    })
    .catch(() => {
        document.getElementById('portfolio-content').innerHTML = "<p>Error loading data.</p>";
    });
</script>
@endsection
