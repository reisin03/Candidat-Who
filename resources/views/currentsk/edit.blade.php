@if(auth('admin')->check())
    @extends('layouts.admin')
@else
    @extends('layouts.app')
@endif

@section('title', 'Edit SK Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit SK Official</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.currentsk.update', $currentsk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" name="fname" class="form-control" value="{{ old('fname', $currentsk->fname) }}" required>
        </div>

        <div class="mb-3">
            <label for="middle_initial" class="form-label">Middle Initial</label>
            <input type="text" name="middle_initial" class="form-control" value="{{ old('middle_initial', $currentsk->middle_initial) }}" maxlength="5" placeholder="e.g., A">
        </div>

        <div class="mb-3">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" name="lname" class="form-control" value="{{ old('lname', $currentsk->lname) }}" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $currentsk->age) }}" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" {{ old('gender', $currentsk->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $currentsk->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $currentsk->birthdate) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $currentsk->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $currentsk->email) }}" placeholder="example@email.com">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $currentsk->phone) }}" placeholder="+63 912 345 6789">
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select name="position" class="form-control" required>
                <option value="Chairperson" {{ old('position', $currentsk->position) == 'Chairperson' ? 'selected' : '' }}>Chairperson</option>
                <option value="SK Kagawad" {{ old('position', $currentsk->position) == 'SK Kagawad' ? 'selected' : '' }}>SK Kagawad</option>
                <option value="SK Secretary" {{ old('position', $currentsk->position) == 'SK Secretary' ? 'selected' : '' }}>SK Secretary</option>
                <option value="SK Treasurer" {{ old('position', $currentsk->position) == 'SK Treasurer' ? 'selected' : '' }}>SK Treasurer</option>
                <option value="SK Auditor" {{ old('position', $currentsk->position) == 'SK Auditor' ? 'selected' : '' }}>SK Auditor</option>
                <option value="SK P.R.O" {{ old('position', $currentsk->position) == 'SK P.R.O' ? 'selected' : '' }}>SK P.R.O</option>
                <option value="SK Sergeant-at-Arms" {{ old('position', $currentsk->position) == 'SK Sergeant-at-Arms' ? 'selected' : '' }}>SK Sergeant-at-Arms</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Platform</label>
            <textarea name="platform" class="form-control">{{ old('platform', $currentsk->platform) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="credentials" class="form-label">Credentials</label>
            <textarea name="credentials" class="form-control">{{ old('credentials', $currentsk->credentials) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($currentsk->photo)
                <img src="{{ asset('storage/' . $currentsk->photo) }}" alt="Current SK Photo" class="mt-2" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update SK Official</button>
    </form>
</div>
@endsection
