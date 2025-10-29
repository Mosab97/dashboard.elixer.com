<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($config['singular_name'] . ' Details') }}</h3>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                {{-- Translatable Name Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Name') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <input type="text" name="title[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error("title.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter Name in ' . strtoupper($locale)) }}"
                                value="{{ old("title.$locale", isset($_model) ? $_model->getTranslation('title', $locale) : '') }}" />
                            @error("title.$locale")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row">
                {{-- Translatable Description Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Description') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <textarea name="description[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error("description.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter Description in ' . strtoupper($locale)) }}">{{ old("description.$locale", isset($_model) ? $_model->getTranslation('description', $locale) : '') }}</textarea>
                            @error("description.$locale")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <!-- How We Work Icon Upload -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('How We Work Icon') }}</label>
                        <input type="file" name="icon" id="icon"
                            class="form-control form-control-solid @error('how_we_work_icon') is-invalid @enderror"
                            accept="image/*">
                        @error('how_we_work_icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($_model->exists && $_model->icon)
                            <div class="mt-3">
                                <a href="{{ $_model->icon_path }}" target="_blank">
                                    <img src="{{ $_model->icon_path }}" alt="Current Icon" class="img-thumbnail"
                                        style="max-width: 100px; max-height: 100px;">
                                </a>
                                <p class="text-muted mt-1">{{ t('Current icon') }}</p>
                            </div>
                        @endif
                        <div class="form-text">{{ t('Upload how we work icon (optional, max 2MB)') }}</div>
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
                        <div class="form-text">{{ t('Inactive sliders will not be displayed to customers') }}</div>
                    </div>
                </div>

                @if ($_model->exists && $_model->icon)
                    <!-- Delete how we work icon -->
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="delete_icon" id="delete_icon"
                                    value="1"
                                    {{ old('delete_icon', $_model->delete_icon ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold fs-6" for="active">
                                    {{ t('Delete How We Work Icon') }}
                                </label>
                            </div>
                            <div class="form-text">
                                {{ t('Delete how we work icon will delete the icon from the database') }}
                            </div>
                        </div>
                    </div>
                @endif


            </div>


        </div>
    </div>
</div>
