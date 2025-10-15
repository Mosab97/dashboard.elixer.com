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
                            <input type="text" name="name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error("name.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter Name in ' . strtoupper($locale)) }}"
                                value="{{ old("name.$locale", isset($_model) ? $_model->getTranslation('name', $locale) : '') }}" />
                            @error("name.$locale")
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
                <!-- Products -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Products') }}</label>
                        <select class="form-select form-select-solid mb-3 mb-lg-0 validate-required"
                            name="product_ids[]" id="product_ids" data-control="select2"
                            data-placeholder="{{ t('Select Products') }}" multiple="multiple">
                            @foreach ($products_list ?? [] as $product)
                                <option value="{{ $product->id }}"
                                    @if (isset($_model)) @if (in_array($product->id, $_model->products->pluck('id')->toArray()))
                                        selected @endif
                                    @endif>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_ids[]')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Image Before Upload -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Image Before') }}</label>
                        <input type="file" name="image_before" id="image_before"
                            class="form-control form-control-solid @error('image_before') is-invalid @enderror"
                            accept="image/*">
                        @error('image_before')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($_model->exists && $_model->image_before)
                            <div class="mt-3">
                                <a href="{{ $_model->image_before_path }}" target="_blank">
                                    <img src="{{ $_model->image_before_path }}" alt="Current Image"
                                        class="img-thumbnail" style="max-width: 100px; max-height: 100px;">

                                </a>
                                <p class="text-muted mt-1">{{ t('Current image') }}</p>
                            </div>
                        @endif
                        <div class="form-text">{{ t('Upload image before (optional, max 2MB)') }}</div>
                    </div>
                </div>

                <!-- Image After Upload -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Image After') }}</label>
                        <input type="file" name="image_after" id="image_after"
                            class="form-control form-control-solid @error('image_after') is-invalid @enderror"
                            accept="image/*">
                        @error('image_after')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($_model->exists && $_model->image_after)
                            <div class="mt-3">
                                <a href="{{ $_model->image_after_path }}" target="_blank">
                                    <img src="{{ $_model->image_after_path }}" alt="Current Image"
                                        class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                </a>
                                <p class="text-muted mt-1">{{ t('Current image') }}</p>
                            </div>
                        @endif
                        <div class="form-text">{{ t('Upload image after (optional, max 1MB)') }}</div>
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
                        <div class="form-text">{{ t('Inactive categories will not be displayed to customers') }}</div>
                    </div>
                </div>

                @if ($_model->exists)
                    @if ($_model->image_before)
                        <!-- Delete image -->
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="delete_image_before"
                                        id="delete_image_before" value="1"
                                        {{ old('delete_image_before', $_model->delete_image_before ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold fs-6" for="active">
                                        {{ t('Delete Image Before') }}
                                    </label>
                                </div>
                                <div class="form-text">
                                    {{ t('Delete image before will delete the image from the database and the file from the server') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($_model->image_after)
                        <!-- Delete Icon -->
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="delete_image_after"
                                        id="delete_image_after" value="1"
                                        {{ old('delete_image_after', $_model->delete_image_after ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold fs-6" for="active">
                                        {{ t('Delete Image After') }}
                                    </label>
                                </div>
                                <div class="form-text">
                                    {{ t('Delete image after will delete the image from the database') }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>


        </div>
    </div>
</div>
