<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($config['singular_name'] . ' Details') }}</h3>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">


            <div class="row">
                <!-- Code -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Code') }}</label>
                        <input type="text" name="code" id="code"
                            class="form-control form-control-solid validate-required @error('code') is-invalid @enderror"
                            value="{{ old('code', $_model->code ?? '') }}"
                            placeholder="{{ t('Enter Code') }}" min="0">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Discount -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Discount') }}</label>
                        <input type="number" name="discount" id="discount"
                            class="form-control form-control-solid validate-required @error('discount') is-invalid @enderror"
                            value="{{ old('discount', $_model->discount ?? 0) }}"
                            placeholder="{{ t('Enter Discount') }}" min="0">
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Expiry Date -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Expiry Date') }}</label>
                        <input type="date" name="expiry_date" id="expiry_date"
                            class="form-control form-control-solid validate-required @error('expiry_date') is-invalid @enderror"
                            value="{{ old('expiry_date', $_model->expiry_date?->format('Y-m-d') ?? '') }}"
                            placeholder="{{ t('Enter Expiry Date') }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Active Status -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="active" id="active" value="1"
                                {{ old('active', $_model->active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold fs-6" for="active">
                                {{ t('Active') }}
                            </label>
                        </div>
                        <div class="form-text">{{ t('Inactive coupons will not be displayed to customers') }}</div>
                    </div>
                </div>



            </div>



        </div>
    </div>
</div>
