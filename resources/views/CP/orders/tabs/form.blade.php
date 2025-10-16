<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($config['singular_name'] . ' Details') }}</h3>
        </div>
    </div>

    <div class="card-body p-9">
        {{-- Customer Information --}}
        <div class="row mb-5">
            <div class="col-12">
                <h4 class="fw-bold mb-4">{{ t('Customer Information') }}</h4>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('First Name') }}</label>
                    <input type="text" name="first_name" readonly
                        class="form-control form-control-solid"
                        value="{{ old('first_name', $_model->first_name ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Last Name') }}</label>
                    <input type="text" name="last_name" readonly
                        class="form-control form-control-solid"
                        value="{{ old('last_name', $_model->last_name ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Phone') }}</label>
                    <input type="text" name="phone" readonly
                        class="form-control form-control-solid"
                        value="{{ old('phone', $_model->phone ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Email') }}</label>
                    <input type="email" name="email" readonly
                        class="form-control form-control-solid"
                        value="{{ old('email', $_model->email ?? '') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Address') }}</label>
                    <textarea name="address" readonly rows="2"
                        class="form-control form-control-solid">{{ old('address', $_model->address ?? '') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Region') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->region->name ?? 'N/A' }}">
                </div>
            </div>
        </div>

        {{-- Order Information --}}
        <div class="row mb-5">
            <div class="col-12">
                <h4 class="fw-bold mb-4">{{ t('Order Information') }}</h4>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Delivery Method') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->delivery_method ? $_model->delivery_method->getLabel() : 'N/A' }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Payment Method') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->payment_method ? $_model->payment_method->getLabel() : 'N/A' }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Coupon Code') }}</label>
                    <input type="text" name="coupon_code" readonly
                        class="form-control form-control-solid"
                        value="{{ old('coupon_code', $_model->coupon_code ?? 'N/A') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Read Conditions') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->read_conditions ? t('Yes') : t('No') }}">
                </div>
            </div>
        </div>

        {{-- Pricing Information --}}
        <div class="row mb-5">
            <div class="col-12">
                <h4 class="fw-bold mb-4">{{ t('Pricing Information') }}</h4>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Sub Total') }}</label>
                    <input type="text" name="sub_total" readonly
                        class="form-control form-control-solid"
                        value="{{ number_format($_model->sub_total ?? 0, 2) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Delivery Fee') }}</label>
                    <input type="text" name="delivery_fee" readonly
                        class="form-control form-control-solid"
                        value="{{ number_format($_model->delivery_fee ?? 0, 2) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Total Before Discount') }}</label>
                    <input type="text" name="total_price_before_discount" readonly
                        class="form-control form-control-solid"
                        value="{{ number_format($_model->total_price_before_discount ?? 0, 2) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Discount') }}</label>
                    <input type="text" name="discount" readonly
                        class="form-control form-control-solid"
                        value="{{ number_format($_model->discount ?? 0, 2) }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2 text-success">{{ t('Total Price After Discount') }}</label>
                    <input type="text" name="total_price_after_discount" readonly
                        class="form-control form-control-solid fw-bold text-success fs-3"
                        value="{{ number_format($_model->total_price_after_discount ?? 0, 2) }}">
                </div>
            </div>
        </div>

        {{-- Order Dates --}}
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold mb-4">{{ t('Order Timeline') }}</h4>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Created At') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->created_at ? $_model->created_at->format('Y-m-d H:i:s') : 'N/A' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="fv-row mb-7">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Updated At') }}</label>
                    <input type="text" readonly
                        class="form-control form-control-solid"
                        value="{{ $_model->updated_at ? $_model->updated_at->format('Y-m-d H:i:s') : 'N/A' }}">
                </div>
            </div>
        </div>
    </div>
</div>
