@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-primary">TOTAL SKILLS</h6>
                    <h3>{{ $skillsCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-success">TOTAL PROJECTS</h6>
                    <h3>{{ $projectsCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="text-primary">Welcome to Admin Dashboard</h5>
            <p>Ini adalah halaman utama dashboard kamu. Gunakan menu di sidebar untuk mengelola <b>Skills</b> dan <b>Projects</b>.</p>
        </div>
    </div>
</div>
@endsection
