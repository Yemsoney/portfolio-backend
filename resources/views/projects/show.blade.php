@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $project->title }}</span>
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">Back to Projects</a>
                </div>

                <div class="card-body">
                    @if ($project->image_url)
                        <div class="text-center mb-4">
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="img-fluid" style="max-height: 400px;">
                        </div>
                    @endif

                    <h4>Description</h4>
                    <p>{{ $project->description }}</p>

                    @if ($project->technologies)
                        <h4>Technologies</h4>
                        <div class="mb-3">
                            @foreach ($project->technologies as $tech)
                                <span class="badge bg-primary">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if ($project->project_url)
                        <h4>Project URL</h4>
                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer">{{ $project->project_url }}</a>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Edit Project</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection