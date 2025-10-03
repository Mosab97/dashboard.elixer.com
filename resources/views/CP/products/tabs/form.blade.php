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
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Price') }}</label>
                        <input type="number" name="price" id="price"
                            class="form-control form-control-solid validate-required @error('price') is-invalid @enderror"
                            value="{{ old('price', $_model->price ?? '') }}" placeholder="{{ t('Enter Price') }}"
                            min="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Discount %') }}</label>
                        <input type="number" name="discount" id="discount"
                            class="form-control form-control-solid validate-required @error('discount') is-invalid @enderror"
                            value="{{ old('discount', $_model->discount ?? '') }}"
                            placeholder="{{ t('Enter Discount %') }}" min="0">
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Quantity') }}</label>
                        <input type="number" name="quantity" id="quantity"
                            class="form-control form-control-solid validate-required @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', $_model->quantity ?? '') }}"
                            placeholder="{{ t('Enter Quantity') }}" min="0">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Category') }}</label>
                        <select name="category_id"
                            class="form-select form-select-solid mb-3 mb-lg-0 validate-required @error('category_id') is-invalid @enderror">
                            <option value="">{{ t('Select Category') }}</option>
                            @foreach ($category_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('category_id', $_model->category_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
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
                        <div class="form-text">{{ t('Inactive categories will not be displayed to customers') }}</div>
                    </div>
                </div>
                <!-- Featured Status -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="featured" id="featured"
                                value="1" {{ old('featured', $_model->featured ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold fs-6" for="featured">
                                {{ t('Featured') }}
                            </label>
                        </div>
                    </div>
                </div>



            </div>


        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle image file preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-section').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle icon file preview
        document.getElementById('icon').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('icon-preview').src = e.target.result;
                    document.getElementById('image-preview-section').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialize Select2 for restaurant dropdown
        if (typeof KTSelect2 !== 'undefined') {
            KTSelect2.init();
        }
    });
</script>
