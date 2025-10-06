<div class="modal-content">

    <div class="modal-header" id="kt_modal_showCalls_header">
        <!--begin::Modal preparation_time-->

        <!--end::Modal preparation_time-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>

    <div class="modal-body scroll-y ">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">{{ __('Attachments') }} </h3>
                        </div>
                        <div class="card-toolbar">
                            @can('policyOffer_edit')
                                <a href="#" class="btn btn-sm btn-success ms-5" id="AddAttachmentModal">
                                    <span class="indicator-label">
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                    rx="10" fill="currentColor" />
                                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        {{ __('Add New Attachment') }} </span>
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
                            id="kt_table_policyOffers_attachments">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th>ID</th>
                                    <th class="min-w-100px mw-100px">{{ __('File Name') }}</th>
                                    <th class="min-w-100px mw-100px">{{ __('Type') }}</th>
                                    <th class="min-w-100px mw-100px">{{ __('Source') }}</th>
                                    <th class="min-w-100px mw-100px">{{ __('Created at') }}</th>
                                    <th class="">{{ __('Actions') }}</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->

                        </table>
                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>

@include('policyOffers.attachments.scripts')
