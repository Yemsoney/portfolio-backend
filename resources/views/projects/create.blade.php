@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Project</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Project Image</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="project_url">Project URL (optional)</label>
                            <input id="project_url" type="url" class="form-control @error('project_url') is-invalid @enderror" name="project_url" value="{{ old('project_url') }}">
                            @error('project_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="technologies">Technologies (comma-separated)</label>
                            <input id="technologies" type="text" class="form-control @error('technologies') is-invalid @enderror" name="technologies" value="{{ old('technologies') }}" placeholder="HTML, CSS, JavaScript">
                            @error('technologies')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection