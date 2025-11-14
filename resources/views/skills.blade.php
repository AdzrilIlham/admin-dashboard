@extends('layouts.public')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">My Skills</h1>
    <div id="skills-content" class="row justify-content-center">
        <p>Loading skills...</p>
    </div>
</div>

<script>
fetch('/api/portfolio/skills')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('skills-content');
        if (data.success && data.data.length > 0) {
            container.innerHTML = data.data.map(skill => `
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm text-center p-3">
                        <h5>${skill.name}</h5>
                        <p class="text-muted">${skill.proficiency}</p>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: ${skill.level}%"></div>
                        </div>
                        <small>${skill.level}%</small>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = "<p>No skills found.</p>";
        }
    })
    .catch(() => {
        document.getElementById('skills-content').innerHTML = "<p>Error loading skills.</p>";
    });
</script>
@endsection
