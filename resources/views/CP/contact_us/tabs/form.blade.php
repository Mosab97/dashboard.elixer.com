<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($config['singular_name'] . ' Details') }}</h3>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">


            <div class="row">
                <!-- name -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Name') }}</label>
                        <input type="text" name="name" id="name"
                            class="form-control form-control-solid @error('name') is-invalid @enderror"
                            value="{{ old('name', $_model->name ?? '') }}"
                            placeholder="{{ t('Enter Name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ t('Enter Name') }}</div>
                    </div>
                </div>
                <!-- email -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Email') }}</label>
                        <input type="email" name="email" id="email"
                            class="form-control form-control-solid @error('email') is-invalid @enderror"
                            value="{{ old('email', $_model->email ?? '') }}"
                            placeholder="{{ t('Enter Email') }}">
                    </div>
                </div>
                <!-- phone -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Phone') }}</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control form-control-solid @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $_model->phone ?? '') }}"
                            placeholder="{{ t('Enter Phone') }}">
                    </div>
                </div>
                <!-- subject -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Subject') }}</label>
                        <input type="text" name="subject" id="subject"
                            class="form-control form-control-solid @error('subject') is-invalid @enderror"
                            value="{{ old('subject', $_model->subject ?? '') }}"
                            placeholder="{{ t('Enter Subject') }}">
                    </div>
                </div>
                <!-- message -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Message') }}</label>
                        <textarea name="message" id="message" class="form-control form-control-solid @error('message') is-invalid @enderror"
                            placeholder="{{ t('Enter Message') }}">{{ old('message', $_model->message ?? '') }}</textarea>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
