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
                                {{ t('Question') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <input type="text" name="question[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error("question.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter Question in ' . strtoupper($locale)) }}"
                                value="{{ old("question.$locale", isset($_model) ? $_model->getTranslation('question', $locale) : '') }}" />
                            @error("question.$locale")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
                {{-- Translatable Answer Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Answer') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <textarea name="answer[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0
                                {{-- validate-required --}}
                                 @error("answer.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter Answer in ' . strtoupper($locale)) }}">{!! old("answer.$locale", isset($_model) ? $_model->getTranslation('answer', $locale) : '') !!}</textarea>
                            @error("answer.$locale")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach

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
                        <div class="form-text">{{ t('Inactive categories will not be displayed to customers') }}</div>
                    </div>
                </div>



            </div>


        </div>
    </div>
</div>

