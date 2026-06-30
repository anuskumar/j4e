<form action="{{ route('reseller.addressdataupdate') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $authdata->id }}">

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               name="name" placeholder="Enter full name"
               value="{{ old('name', $adreesdata->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Address Line 1</label>
        <input type="text" class="form-control @error('address_line1') is-invalid @enderror"
               name="address_line1" placeholder="Street address, P.O. box"
               value="{{ old('address_line1', $adreesdata->address_line1 ?? '') }}">
        @error('address_line1')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Address Line 2</label>
        <input type="text" class="form-control @error('address_line2') is-invalid @enderror"
               name="address_line2" placeholder="Apartment, suite, unit, building, floor, etc."
               value="{{ old('address_line2', $adreesdata->address_line2 ?? '') }}">
        @error('address_line2')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Country <span class="text-danger">*</span></label>
        <select name="country" id="country" class="form-select select2-select @error('country') is-invalid @enderror" required>
            <option value="">Select Country</option>
            @foreach($country as $loc)
                <option value="{{ $loc->id }}"
                    {{ old('country', $adreesdata->country ?? '') == $loc->id ? 'selected' : '' }}>
                    {{ $loc->country_name }}
                </option>
            @endforeach
        </select>
        @error('country')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">City <span class="text-danger">*</span></label>
        <select name="city" id="city" class="form-select select2-select @error('city') is-invalid @enderror" required>
            <option value="">Select City</option>
        </select>
        @error('city')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Postal Code</label>
        <input type="text" class="form-control @error('postcode') is-invalid @enderror"
               name="postcode" placeholder="Enter postal code"
               value="{{ old('postcode', $adreesdata->postcode ?? '') }}">
        @error('postcode')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror"
               name="phone" placeholder="Enter phone number"
               value="{{ old('phone', $adreesdata->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>Update Address
    </button>
</form>
