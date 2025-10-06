@php
    $config = config('modules.attachments');
@endphp

<div class="modal-content">
    {{-- Modal Header --}}
    <div class="modal-header">
        <h2 class="fw-bold">{{ t('Add ' . $config['singular_name']) }}</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>

    {{-- Modal Body --}}
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form id="{{ $config['singular_key'] }}_modal_form" class="form"
            data-editMode="{{ isset($_model) ? 'enabled' : 'disabled' }}"
            action="{{ route($config['full_route_name'] . '.addedit') }}">
            @csrf
            <input type="hidden" name="attachable_type" value="{{ $attachable_type }}">
            <input type="hidden" name="attachable_id" value="{{ $attachable_id }}">
            @if (isset($_model))
                <input type="hidden" name="{{ $config['id_field'] }}" value="{{ $_model->id }}">
            @endif

            <div class="fv-row">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" for="formFile">{{ __('Attachment') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mb-3">
                    <input class="form-control @if (!$_model->exists) validate-required @endif" type="file" id="formFile" name="attachment_file">
                </div>
                <!--end::Input-->
            </div>

            {{-- Form Actions --}}
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3"
                    data-kt-modal-action="cancel{{ $config['singular_key'] }}" data-bs-dismiss="modal">
                    {{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary"
                    data-kt-modal-action="submit{{ $config['singular_key'] }}">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">
                        {{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
