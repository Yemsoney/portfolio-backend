@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Projects</span>
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">Add New Project</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (count($projects) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Technologies</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>
                                                @if ($project->image_url)
                                                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" width="80">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $project->title }}</td>
                                            <td>
                                                @if ($project->technologies)
                                                    @foreach ($project->technologies as $tech)
                                                        <span class="badge bg-primary">{{ $tech }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">No projects found. <a href="{{ route('projects.create') }}">Create your first project</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection