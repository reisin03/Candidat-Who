@extends('layouts.admin')

@section('title', 'Edit Running SK Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Running SK Official</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.runningsk.update', $official) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" name="fname" class="form-control" value="{{ old('fname', $official->fname) }}" required>
        </div>

        <div class="mb-3">
            <label for="middle_initial" class="form-label">Middle Initial</label>
            <input type="text" name="middle_initial" class="form-control" value="{{ old('middle_initial', $official->middle_initial) }}" maxlength="5" placeholder="e.g., A">
        </div>

        <div class="mb-3">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" name="lname" class="form-control" value="{{ old('lname', $official->lname) }}" required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select name="position" class="form-control" required>
                <option value="SK Chairperson" {{ old('position', $official->position) == 'SK Chairperson' ? 'selected' : '' }}>SK Chairperson</option>
                <option value="SK Kagawad" {{ old('position', $official->position) == 'SK Kagawad' ? 'selected' : '' }}>SK Kagawad</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $official->age) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $official->address) }}">
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $official->birthdate) }}">
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="Male" {{ old('gender', $official->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $official->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <!-- Platform Section -->
        <div class="mb-3">
            <label class="form-label">Platforms</label>
            <div id="platforms-container">
                @php
                    $platforms = old('platforms', $official->platform ?? []);
                    if (!is_array($platforms)) {
                        $platforms = $platforms ? [$platforms] : [];
                    }
                @endphp
                @if(count($platforms) > 0)
                    @foreach($platforms as $index => $platform)
                        <div class="input-group mb-2 platform-item">
                            <input type="text" name="platforms[]" class="form-control" value="{{ $platform }}" placeholder="Enter platform">
                            <button type="button" class="btn btn-outline-danger remove-platform" style="{{ count($platforms) > 1 ? '' : 'display: none;' }}">Remove</button>
                        </div>
                    @endforeach
                @else
                    <div class="input-group mb-2 platform-item">
                        <input type="text" name="platforms[]" class="form-control" placeholder="Enter platform">
                        <button type="button" class="btn btn-outline-danger remove-platform" style="display: none;">Remove</button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-platform">Add Platform</button>
        </div>

        <!-- Credentials Section -->
        <div class="mb-3">
            <label class="form-label">Credentials</label>
            <div id="credentials-container">
                @php
                    $credentials = old('credentials', $official->credentials ?? []);
                    if (!is_array($credentials)) {
                        $credentials = $credentials ? [$credentials] : [];
                    }
                @endphp
                @if(count($credentials) > 0)
                    @foreach($credentials as $index => $credential)
                        <div class="input-group mb-2 credential-item">
                            <input type="text" name="credentials[]" class="form-control" value="{{ $credential }}" placeholder="Enter credential">
                            <button type="button" class="btn btn-outline-danger remove-credential" style="{{ count($credentials) > 1 ? '' : 'display: none;' }}">Remove</button>
                        </div>
                    @endforeach
                @else
                    <div class="input-group mb-2 credential-item">
                        <input type="text" name="credentials[]" class="form-control" placeholder="Enter credential">
                        <button type="button" class="btn btn-outline-danger remove-credential" style="display: none;">Remove</button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-credential">Add Credential</button>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $official->email) }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $official->phone) }}" maxlength="20">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($official->photo)
                <img src="{{ asset('storage/' . $official->photo) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Running SK Official</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Platform management
    const addPlatformBtn = document.getElementById('add-platform');
    const platformsContainer = document.getElementById('platforms-container');

    addPlatformBtn.addEventListener('click', function() {
        const platformItems = platformsContainer.querySelectorAll('.platform-item');
        const newItem = platformItems[0].cloneNode(true);
        const input = newItem.querySelector('input');
        const removeBtn = newItem.querySelector('.remove-platform');

        input.value = '';
        removeBtn.style.display = 'inline-block';

        platformsContainer.appendChild(newItem);
        updateRemoveButtons(platformsContainer, '.remove-platform');
    });

    // Credential management
    const addCredentialBtn = document.getElementById('add-credential');
    const credentialsContainer = document.getElementById('credentials-container');

    addCredentialBtn.addEventListener('click', function() {
        const credentialItems = credentialsContainer.querySelectorAll('.credential-item');
        const newItem = credentialItems[0].cloneNode(true);
        const input = newItem.querySelector('input');
        const removeBtn = newItem.querySelector('.remove-credential');

        input.value = '';
        removeBtn.style.display = 'inline-block';

        credentialsContainer.appendChild(newItem);
        updateRemoveButtons(credentialsContainer, '.remove-credential');
    });

    // Function to update remove button visibility
    function updateRemoveButtons(container, selector) {
        const items = container.querySelectorAll(selector);
        const totalItems = container.querySelectorAll('.platform-item, .credential-item').length;

        items.forEach((btn, index) => {
            if (totalItems > 1) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    // Event delegation for remove buttons
    platformsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-platform')) {
            e.target.closest('.platform-item').remove();
            updateRemoveButtons(platformsContainer, '.remove-platform');
        }
    });

    credentialsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-credential')) {
            e.target.closest('.credential-item').remove();
            updateRemoveButtons(credentialsContainer, '.remove-credential');
        }
    });
});
</script>
@endsection
