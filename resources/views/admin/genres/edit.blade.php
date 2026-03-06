@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Genre</h3>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.genres.update', $genre->id) }}" class="col-md-6">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Genre Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $genre->name) }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.genres.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
