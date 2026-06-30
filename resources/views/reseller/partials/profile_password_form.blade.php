@if(session('password_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('password_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('password_error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('password_error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('reseller.passwordupdate') }}" method="POST" name="passwordForm" onsubmit="return validateForm()">
    @csrf
    <input type="hidden" name="id" value="{{ $authdata->id }}">

    <div class="mb-3">
        <label class="form-label">Current Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('oldpassword') is-invalid @enderror"
               name="oldpassword" placeholder="Enter your current password" required>
        @error('oldpassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">New Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('newpassword') is-invalid @enderror"
               name="newpassword" placeholder="Enter your new password" required>
        <small class="text-muted">Password must be at least 8 characters long</small>
        @error('newpassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
               name="confirm_password" placeholder="Confirm your new password" required>
        @error('confirm_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-key me-1"></i>Change Password
    </button>
</form>
