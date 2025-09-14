@if(auth('admin')->check())
    @extends('layouts.admin')
@else
    @extends('layouts.app')
@endif

@section('title', 'Add SK Official')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ Add SK Official</h2>
    <form action="{{ route('admin.currentsk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="fname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Middle Initial</label>
            <input type="text" name="middle_initial" class="form-control" maxlength="5" placeholder="e.g., A">
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Birthdate</label>
            <input type="date" name="birthdate" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="example@email.com">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="+63 912 345 6789">
        </div>

        <div class="mb-3">
            <label class="form-label">Position</label>
            <select name="position" class="form-control" required>
                <option value="Chairperson">Chairperson</option>
                <option value="SK Kagawad">SK Kagawad</option>
                <option value="SK Secretary">SK Secretary</option>
                <option value="SK Treasurer">SK Treasurer</option>
                <option value="SK Auditor">SK Auditor</option>
                <option value="SK P.R.O">SK P.R.O</option>
                <option value="SK Sergeant-at-Arms">SK Sergeant-at-Arms</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Platform</label>
            <textarea name="platform" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Credentials</label>
            <textarea name="credentials" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.currentsk.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
