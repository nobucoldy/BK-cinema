@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Actor</h3>

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

    <form method="POST" action="{{ route('admin.actors.update', $actor->id) }}" class="col-md-6">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Actor Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $actor->name) }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.actors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
