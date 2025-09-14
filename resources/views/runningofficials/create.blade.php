@extends('layouts.admin')

@section('title', 'Add Running Official')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Running Official</h2>
    <form action="{{ route('admin.runningofficials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Initial</label>
                <input type="text" name="middle_initial" class="form-control" maxlength="5" placeholder="e.g., A">
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" required>
            </div>
        </div>

        <!-- Gender + Birthdate + Age Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" min="18" max="100" required>
            </div>
        </div>

        <!-- Address Row -->
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2"></textarea>
        </div>

        <!-- Position + Email + Phone Row -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Position</label>
                <select name="position" class="form-control" required>
                    <option value="Barangay Captain">Barangay Captain</option>
                    <option value="Kagawad">Kagawad</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" maxlength="20">
            </div>
        </div>

        <!-- Platforms Section -->
        <div class="mb-3">
            <label class="form-label">Platforms</label>
            <div id="platforms-container">
                <div class="input-group mb-2 platform-item">
                    <input type="text" name="platforms[]" class="form-control" placeholder="Enter platform">
                    <button type="button" class="btn btn-outline-danger remove-platform" style="display: none;">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-platform">Add Platform</button>
        </div>

        <!-- Credentials Section -->
        <div class="mb-3">
            <label class="form-label">Credentials</label>
            <div id="credentials-container">
                <div class="input-group mb-2 credential-item">
                    <input type="text" name="credentials[]" class="form-control" placeholder="Enter credential">
                    <button type="button" class="btn btn-outline-danger remove-credential" style="display: none;">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="add-credential">Add Credential</button>
        </div>

        <!-- Photo Row -->
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <!-- Buttons Row -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save</button>
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

    birthdateInput.addEventListener('change', function() {
        const age = calculateAge(this.value);
        ageInput.value = age;
    });

    // Dynamic fields management function
    function updateRemoveButtons(container, selector) {
        const items = container.querySelectorAll(selector);
        const totalItems = container.querySelectorAll('.platform-item, .credential-item').length;

        items.forEach((btn, index) => {
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

    // Credential management
    const addCredentialBtn = document.getElementById('add-credential');
    const credentialsContainer = document.getElementById('credentials-container');

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
