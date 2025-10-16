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
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                @if ($_model->exists)
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Price After Discount') }}</label>
                            <input type="number" name="price_after_discount" id="price_after_discount" readonly
                                class="form-control form-control-solid validate-required @error('discount') is-invalid @enderror"
                                disabled value="{{ old('price_after_discount', $_model->price_after_discount ?? '') }}"
                                placeholder="{{ t('Enter Price After Discount') }}" min="0">
                            @error('price_after_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
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
            </div>
            <div class="row">
                @if ($_model->exists)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Slug') }}</label>
                            <input disabled class="form-control form-control-solid"
                                value="{{ old('slug', $_model->slug ?? '') }}" placeholder="{{ t('Enter Slug') }}">
                        </div>
                    </div>
                @endif

                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Rate Count') }}</label>
                        <input type="number" name="rate_count" id="rate_count"
                            class="form-control form-control-solid validate-required @error('rate_count') is-invalid @enderror"
                            value="{{ old('rate_count', $_model->rate_count ?? '') }}"
                            placeholder="{{ t('Enter Rate Count') }}" min="0" max="5">
                        @error('rate_count')
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
                <!-- Product Image Upload -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Product Image') }}</label>
                        <input type="file" name="image" id="image"
                            class="form-control form-control-solid @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($_model->exists && $_model->image)
                            <div class="mt-3">
                                <img src="{{ $_model->image_path }}" alt="Current Image" class="img-thumbnail"
                                    style="max-width: 100px; max-height: 100px;">
                                <p class="text-muted mt-1">{{ t('Current image') }}</p>
                            </div>
                        @endif
                        <div class="form-text">{{ t('Upload product image (optional, max 2MB)') }}</div>
                    </div>
                </div>


            </div>



            <div class="row">
                <!-- Active Status -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="active" id="active"
                                value="1" {{ old('active', $_model->active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold fs-6" for="active">
                                {{ t('Active') }}
                            </label>
                        </div>
                        <div class="form-text">{{ t('Inactive categories will not be displayed to customers') }}</div>
                    </div>
                </div>
                @if ($_model->exists && $_model->image)
                    <!-- Delete image -->
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="delete_image"
                                    id="delete_image" value="1"
                                    {{ old('delete_image', $_model->delete_image ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold fs-6" for="delete_image">
                                    {{ t('Delete Image') }}
                                </label>
                            </div>
                            <div class="form-text">{{ t('Delete image will delete the image from the database') }}
                            </div>
                        </div>
                    </div>
                @endif

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

            <div class="row" id="html_editor_section">
                <!-- How to Use -->
                @foreach (config('app.locales') as $language)
                    <div class="col-md-4">
                        <div class="mb-5">
                            <label class="form-label">{{ t('How to Use') }}
                                ({{ strtoupper($language) }})
                            </label>
                            <textarea class="form-control" rows="6" name="how_to_use[{{ $language }}]">{!! old('how_to_use.' . $language, $_model->getTranslation('how_to_use', $language) ?? '') !!}</textarea>
                        </div>
                    </div>
                @endforeach
                <!-- Details -->
                @foreach (config('app.locales') as $language)
                    <div class="col-md-4">
                        <div class="mb-5">
                            <label class="form-label">{{ t('Details') }}
                                ({{ strtoupper($language) }})
                            </label>
                            <textarea class="form-control" rows="6" name="details[{{ $language }}]">{!! old('details.' . $language, $_model->getTranslation('details', $language) ?? '') !!}</textarea>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>




<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find all textarea elements in the settings form
        const form = document.getElementById('html_editor_section');
        if (!form) return;

        const textareas = form.querySelectorAll('textarea');
        const editors = []; // Store editor instances for form submission

        // Initialize CKEditor for each textarea
        textareas.forEach((textarea, index) => {
            ClassicEditor.create(textarea, {
                    placeholder: 'Enter content...',
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'link', '|',
                            'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    }
                    // language: 'ar' // uncomment if you want full UI in Arabic
                })
                .then(editor => {
                    // Store editor instance
                    editors.push({
                        editor: editor,
                        textarea: textarea
                    });

                    console.log(`CKEditor initialized for textarea: ${textarea.name || 'unnamed'}`);
                })
                .catch(error => {
                    console.error(
                        `Failed to initialize CKEditor for textarea ${textarea.name || 'unnamed'}:`,
                        error);
                });
        });


    });
</script>
