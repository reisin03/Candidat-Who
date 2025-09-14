@extends('layouts.app')

@section('title', 'Add Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Official</h2>
    <form action="{{ route('admin.brgyofficials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Row 1 --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Middle Initial</label>
                <input type="text" name="middle_initial" class="form-control" maxlength="5" placeholder="e.g., A">
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" min="18" max="100">
            </div>
        </div>

        {{-- Row 3 --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Position</label>
                <select name="position" class="form-control" required>
                    <option value="Barangay Captain">Barangay Captain</option>
                    <option value="Kagawad">Kagawad</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('admin.brgyofficials.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
