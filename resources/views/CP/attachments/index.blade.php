@php
    $config = config('modules.attachments');
    $attachable_type = $_model::class;
    $attachable_id = $_model->id;
@endphp
<div>
    <div class="card mb-5 mb-xl-10" id="kt_{{ $config['singular_key'] }}_attachments_details_view">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">{{ t($config['singular_name']??'' . ' Attachments') }}</h3>
                 <!--end::Svg Icon-->
                 <input type="hidden" data-col-index="attachable_type"

                 value="{{ $attachable_type }}" class="form-control datatable-input form-control-solid w-250px ps-14"/>

                 <input type="hidden" data-col-index="attachable_id"
                 value="{{ $attachable_id }}" class="form-control datatable-input form-control-solid w-250px ps-14"/>

            </div>
            <div class="card-toolbar">
                @can($config['permissions']['create'])
                    <a href="{{ route($config['full_route_name'] . '.create', ['attachable_type' => $attachable_type, 'attachable_id' => $attachable_id]) }}"
                        class="btn btn-primary" id="btnAdd{{ $config['singular_key'] }}">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                    fill="currentColor" />
                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        {{ __('Add New Attachment') }}</span>
                        <span class="indicator-progress">
                            {{ __('Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </a>
                @endcan
            </div>
        </div>

        <!--begin::Card body-->
        <div class="card-body p-9">
            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5"
                id="kt_table_attachments">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th class="min-w-100px mw-100px">{{ __('File Name') }}</th>
                        {{-- <th class="min-w-100px mw-100px">{{ __('Type') }}</th> --}}
                        {{-- <th class="min-w-100px mw-100px">{{ __('Source') }}</th> --}}
                        <th class="min-w-100px mw-100px">{{ __('Created at') }}</th>
                        <th class="">{{ __('Actions') }}</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->

            </table>
        </div>

    </div>
</div>



@push('scripts')
    @include('CP.attachments.scripts.datatableJS')
    @include('CP.attachments.scripts.btnsJS')
    {{-- @include('CP.attachments.scripts') --}}
@endpush
