<form action="{{ route('reseller.bankdataupdate') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $authdata->id }}">

    <div class="mb-3">
        <label class="form-label">Bank Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               name="name" placeholder="Enter bank name"
               value="{{ old('name', $bankData->bank_name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Bank Email</label>
        <input type="email" class="form-control @error('bankname') is-invalid @enderror"
               name="bankname" placeholder="Enter bank email"
               value="{{ old('bankname', $bankData->bank_email ?? '') }}">
        @error('bankname')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Bank Country <span class="text-danger">*</span></label>
        <select name="bank_country" class="form-select select2-select @error('bank_country') is-invalid @enderror" required>
            <option value="">Select Country</option>
            @foreach($country as $loc)
                <option value="{{ $loc->id }}"
                    {{ old('bank_country', $bankData->bank_country ?? '') == $loc->id ? 'selected' : '' }}>
                    {{ $loc->country_name }}
                </option>
            @endforeach
        </select>
        @error('bank_country')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Account IBAN <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('bankaccno') is-invalid @enderror"
               name="bankaccno" placeholder="Enter IBAN number"
               value="{{ old('bankaccno', $bankData->accnt_no ?? '') }}" required>
        @error('bankaccno')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">BIC/SWIFT Code <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('bankbic') is-invalid @enderror"
               name="bankbic" placeholder="Enter BIC/SWIFT code"
               value="{{ old('bankbic', $bankData->bic ?? '') }}" required>
        @error('bankbic')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Comments</label>
        <textarea class="form-control @error('bankcomments') is-invalid @enderror"
                  name="bankcomments" rows="3"
                  placeholder="Enter any additional comments">{{ old('bankcomments', $bankData->comments ?? '') }}</textarea>
        @error('bankcomments')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>Update Bank Details
    </button>
</form>
