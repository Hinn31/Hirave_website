
<link rel="stylesheet" href="{{ asset('css/user-management.css') }}">

<div class="user-form">
    <h3 id="form-title">{{ isset($user) ? 'Edit User' : 'Add User' }}</h3>

    <form
        id="userForm"
        action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <!-- Full Name -->
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname"
                value="{{ old('fullname', $user->fullname ?? '') }}"
                placeholder="Enter full name" required>
        </div>

        <!-- Username -->
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                value="{{ old('username', $user->username ?? '') }}"
                placeholder="Enter username" required>
        </div>

        <!-- Date of Birth -->
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth"
                value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email', $user->email ?? '') }}"
                placeholder="Enter email" required>
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone"
                value="{{ old('phone', $user->phone ?? '') }}"
                placeholder="Enter phone number">
        </div>

        <!-- Role -->
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ old('role', $user->role ?? '') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <button type="submit" class="btn save">{{ isset($user) ? 'Update' : 'Save' }}</button>
            <a href="{{ route('users.index') }}" class="btn cancel">Cancel</a>
        </div>
    </form>
</div>
