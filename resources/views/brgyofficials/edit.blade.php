@extends('layouts.app')

@section('title', 'Edit Barangay Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Barangay Official</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.brgyofficials.update', $official) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" value="{{ old('fname', $official->fname) }}" required>
            </div>
            <div class="col-md-6">
                <label for="middle_initial" class="form-label">Middle Initial</label>
                <input type="text" name="middle_initial" class="form-control" value="{{ old('middle_initial', $official->middle_initial) }}" maxlength="5" placeholder="e.g., A">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" value="{{ old('lname', $official->lname) }}" required>
            </div>
            <div class="col-md-6">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $official->age) }}" min="18" max="100">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" name="position" class="form-control" value="{{ old('position', $official->position) }}" required>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $official->phone) }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $official->email) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $official->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($official->photo)
                <img src="{{ asset('storage/' . $official->photo) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Official</button>
    </form>

</div>
@endsection
