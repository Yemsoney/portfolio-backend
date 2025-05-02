@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Project: {{ $project->title }}</span>
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">Back to Projects</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $project->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Project Image</label>
                            @if ($project->image_url)
                                <div class="mb-2">
                                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            <small class="form-text text-muted">Leave empty to keep the current image.</small>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="project_url">Project URL (optional)</label>
                            <input id="project_url" type="url" class="form-control @error('project_url') is-invalid @enderror" name="project_url" value="{{ old('project_url', $project->project_url) }}">
                            @error('project_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="technologies">Technologies (comma-separated)</label>
                            <input id="technologies" type="text" class="form-control @error('technologies') is-invalid @enderror" name="technologies" value="{{ old('technologies', implode(', ', $project->technologies ?? [])) }}">
                            @error('technologies')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection