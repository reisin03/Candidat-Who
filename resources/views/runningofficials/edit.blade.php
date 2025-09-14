@extends('layouts.admin')

@section('title', 'Edit Running Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Running Official</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.runningofficials.update', $official) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname', $official->fname) }}" required>
                @error('fname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Initial</label>
                <input type="text" name="middle_initial" class="form-control @error('middle_initial') is-invalid @enderror" value="{{ old('middle_initial', $official->middle_initial) }}" maxlength="5" placeholder="e.g., A">
                @error('middle_initial')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname', $official->lname) }}" required>
                @error('lname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Gender + Birthdate + Age Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                    <option value="Male" {{ old('gender', $official->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $official->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', $official->birthdate ? $official->birthdate->format('Y-m-d') : '') }}">
                @error('birthdate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $official->age) }}" min="18" max="100" disabled>
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Address Row -->
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $official->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Position + Email + Phone Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Position</label>
                <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                    <option value="Barangay Captain" {{ old('position', $official->position) == 'Barangay Captain' ? 'selected' : '' }}>Barangay Captain</option>
                    <option value="Kagawad" {{ old('position', $official->position) == 'Kagawad' ? 'selected' : '' }}>Kagawad</option>
                </select>
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $official->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $official->phone) }}" maxlength="20">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Platforms Section -->
        <div class="mb-3">
            <label class="form-label">Platforms</label>
            <div id="platforms-container">
                @php
                    $platforms = old('platforms', is_array($official->platform) ? $official->platform : ($official->platform ? [$official->platform] : []));
                @endphp
                @if(count($platforms) > 0)
                    @foreach($platforms as $index => $platform)
                        <div class="input-group mb-2 platform-item">
                            <input type="text" name="platforms[]" class="form-control @error('platforms.' . $index) is-invalid @enderror" value="{{ $platform }}" placeholder="Enter platform">
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
            @error('platforms')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Credentials Section -->
        <div class="mb-3">
            <label class="form-label">Credentials</label>
            <div id="credentials-container">
                @php
                    $credentials = old('credentials', is_array($official->credentials) ? $official->credentials : ($official->credentials ? [$official->credentials] : []));
                @endphp
                @if(count($credentials) > 0)
                    @foreach($credentials as $index => $credential)
                        <div class="input-group mb-2 credential-item">
                            <input type="text" name="credentials[]" class="form-control @error('credentials.' . $index) is-invalid @enderror" value="{{ $credential }}" placeholder="Enter credential">
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
            @error('credentials')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Photo Row -->
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($official->photo)
                <div class="mt-2">
                    <label class="form-label small text-muted">Current Photo:</label>
                    <img src="{{ asset('storage/' . $official->photo) }}" width="100" class="border rounded" alt="Current Photo">
                    <p class="small text-muted">Upload a new photo to replace the current one.</p>
                </div>
            @endif
        </div>

        <!-- Buttons Row -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.runningofficials.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const birthdateInput = document.querySelector('input[name="birthdate"]');
    const ageInput = document.querySelector('input[name="age"]');

    function calculateAge(birthdate) {
        if (!birthdate) return '';

        const today = new Date();
        const birth = new Date(birthdate);
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }

        return age;
    }

    if (birthdateInput) {
        birthdateInput.addEventListener('change', function() {
            const age = calculateAge(this.value);
            ageInput.value = age;
        });
    }

    // Dynamic fields management function
    function updateRemoveButtons(container, selector) {
        const items = container.querySelectorAll(selector);
        const totalItems = container.querySelectorAll('.platform-item, .credential-item').length;

        items.forEach((btn) => {
            if (totalItems > 1) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    // Platform management
    const addPlatformBtn = document.getElementById('add-platform');
    const platformsContainer = document.getElementById('platforms-container');

    if (addPlatformBtn && platformsContainer) {
        addPlatformBtn.addEventListener('click', function() {
            const platformItems = platformsContainer.querySelectorAll('.platform-item');
            const newItem = platformItems[0].cloneNode(true);
            const input = newItem.querySelector('input');
            const removeBtn = newItem.querySelector('.remove-platform');

            input.value = '';
            removeBtn.style.display = 'none';

            platformsContainer.appendChild(newItem);
            updateRemoveButtons(platformsContainer, '.remove-platform');
        });

        // Event delegation for remove buttons
        platformsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-platform')) {
                e.target.closest('.platform-item').remove();
                updateRemoveButtons(platformsContainer, '.remove-platform');
            }
        });
    }

    // Credential management
    const addCredentialBtn = document.getElementById('add-credential');
    const credentialsContainer = document.getElementById('credentials-container');

    if (addCredentialBtn && credentialsContainer) {
        addCredentialBtn.addEventListener('click', function() {
            const credentialItems = credentialsContainer.querySelectorAll('.credential-item');
            const newItem = credentialItems[0].cloneNode(true);
            const input = newItem.querySelector('input');
            const removeBtn = newItem.querySelector('.remove-credential');

            input.value = '';
            removeBtn.style.display = 'none';

            credentialsContainer.appendChild(newItem);
            updateRemoveButtons(credentialsContainer, '.remove-credential');
        });

        // Event delegation for remove buttons
        credentialsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-credential')) {
                e.target.closest('.credential-item').remove();
                updateRemoveButtons(credentialsContainer, '.remove-credential');
            }
        });
    }
});
</script>
@endsection
