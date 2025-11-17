@extends('layouts.admin')

@section('title', 'Portfolio Management')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Portfolio Management</h1>

    {{-- ============================
        ABOUT SECTION
    ============================= --}}
    <div id="about-section" class="card shadow mb-5">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">About</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.portfolio.update') }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">About Title</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ $portfolio->title }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">About Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ $portfolio->description }}</textarea>
                </div>

                <button class="btn btn-primary">Update About</button>
            </form>

        </div>
    </div>


    {{-- ============================
        SKILLS SECTION
    ============================= --}}
    <div id="skills-section" class="card shadow mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Skills</h5>
            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addSkillModal">
                Add Skill
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Level</th>
                        <th width="120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skills as $skill)
                    <tr>
                        <td>{{ $skill->name }}</td>
                        <td><i class="{{ $skill->icon }} fs-5"></i></td>
                        <td>{{ $skill->level }}%</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editSkillModal{{ $skill->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.portfolio.skills.delete', $skill->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Skill Modal --}}
                    <div class="modal fade" id="editSkillModal{{ $skill->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form class="modal-content"
                                  action="{{ route('admin.portfolio.skills.update', $skill->id) }}"
                                  method="POST">
                                @csrf @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Skill</h5>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control"
                                               value="{{ $skill->name }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Icon (FontAwesome)</label>
                                        <input type="text" name="icon" class="form-control"
                                               value="{{ $skill->icon }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Level (%)</label>
                                        <input type="number" name="level" class="form-control"
                                               value="{{ $skill->level }}">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Add Skill Modal --}}
    <div class="modal fade" id="addSkillModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content"
                  action="{{ route('admin.portfolio.skills.store') }}"
                  method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Skill</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Icon (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Level (%)</label>
                        <input type="number" name="level" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>



    {{-- ============================
        CERTIFICATES SECTION
    ============================= --}}
    <div id="certificates-section" class="card shadow mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Certificates</h5>
            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addCertificateModal">
                Add Certificate
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th width="140px">Image</th>
                        <th>Title</th>
                        <th width="120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $cert)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$cert->image) }}"
                                 width="120" class="rounded shadow-sm">
                        </td>
                        <td>{{ $cert->title }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCertModal{{ $cert->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.portfolio.certificates.delete', $cert->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Certificate Modal --}}
                    <div class="modal fade" id="editCertModal{{ $cert->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form class="modal-content"
                                  action="{{ route('admin.portfolio.certificates.update', $cert->id) }}"
                                  method="POST" enctype="multipart/form-data">

                                @csrf @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Certificate</h5>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control"
                                               value="{{ $cert->title }}">
                                    </div>

                                    <div class="mb-3">
                                        <label>Replace Image (optional)</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Add Certificate Modal --}}
    <div class="modal fade" id="addCertificateModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content"
                  action="{{ route('admin.portfolio.certificates.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Certificate</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>



    {{-- ============================
        PROJECTS SECTION
    ============================= --}}
    <div id="projects-section" class="card shadow mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Projects</h5>
            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addProjectModal">
                Add Project
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th width="140px">Thumbnail</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th width="120px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($projects as $prj)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$prj->thumbnail) }}"
                                 width="120" class="rounded shadow-sm">
                        </td>

                        <td>{{ $prj->name }}</td>

                        <td>
                            <a href="{{ $prj->url }}" target="_blank">
                                Visit
                            </a>
                        </td>

                        <td>
                            <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProjectModal{{ $prj->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.portfolio.projects.delete', $prj->id) }}"
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Project Modal --}}
                    <div class="modal fade" id="editProjectModal{{ $prj->id }}"
                         tabindex="-1">
                        <div class="modal-dialog">
                            <form class="modal-content"
                                  action="{{ route('admin.portfolio.projects.update', $prj->id) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Project</h5>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Project Name</label>
                                        <input type="text" name="name"
                                               value="{{ $prj->name }}"
                                               class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Project URL</label>
                                        <input type="text" name="url"
                                               value="{{ $prj->url }}"
                                               class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Replace Thumbnail</label>
                                        <input type="file" name="thumbnail"
                                               class="form-control">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Add Project Modal --}}
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content"
                  action="{{ route('admin.portfolio.projects.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Project</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Project URL</label>
                        <input type="text" name="url" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
