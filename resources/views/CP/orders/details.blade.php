<!--begin::Modal header-->
<div class="modal-header pb-0 border-0 justify-content-end">
    <!--begin::Close-->
    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
        <i class="ki-duotone ki-cross fs-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
    <!--end::Close-->
</div>
<!--end::Modal header-->

<!--begin::Modal body-->
<div class="modal-body scroll-y mx-5 mx-xl-15">
    <!--begin::Invoice-->
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-lg-1">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                    <!--begin::Invoice 2-->
                    <div class="mt-0">
                        <!--begin::Top-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-6">
                            <div class="flex-sm-row-auto me-sm-5 mb-3 mb-sm-0">
                                <!--begin::Logo-->
                                <a href="#" class="d-flex align-items-center mb-3">
                                    <h2 class="fw-bold text-primary mb-0 fs-3">{{ t('Order Details') }}</h2>
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="fw-semibold fs-7 text-gray-600">
                                    <div>{{ t('Order ID') }}: #{{ $_model->id }}</div>
                                    <div>{{ t('Created At') }}: {{ $_model->created_at ? $_model->created_at->format('Y-m-d H:i:s') : 'N/A' }}</div>
                                </div>
                                <!--end::Text-->
                            </div>
                            <div class="flex-sm-row-auto ms-sm-5">
                                <!--begin::Print Button-->
                                <button type="button" class="btn btn-primary btn-sm btn_print_order">
                                    <i class="fas fa-print me-2"></i>
                                    {{ t('Print') }}
                                </button>
                                <!--end::Print Button-->
                            </div>
                        </div>
                        <!--end::Top-->

                        <!--begin::Separator-->
                        <div class="separator separator-solid mb-6"></div>
                        <!--end::Separator-->

                        <!--begin::Customer Information-->
                        <div class="mb-8">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <h4 class="fw-bold text-gray-800 mb-3">{{ t('Customer Information') }}</h4>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Full Name') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">
                                        {{ trim(($_model->first_name ?? '') . ' ' . ($_model->last_name ?? '')) ?: 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Phone') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $_model->phone ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Email') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $_model->email ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Region') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $_model->region->name ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Address') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $_model->address ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Customer Information-->

                        <!--begin::Separator-->
                        <div class="separator separator-solid mb-10"></div>
                        <!--end::Separator-->

                        <!--begin::Order Information-->
                        <div class="mb-8">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <h4 class="fw-bold text-gray-800 mb-3">{{ t('Order Information') }}</h4>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Status') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">
                                        @if($_model->status)
                                            {!! $_model->status->getBadge() !!}
                                        @else
                                            <span class="badge badge-light-warning">{{ t('Pending') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Delivery Method') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">
                                        {{ $_model->delivery_method ? $_model->delivery_method->getLabel() : 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Payment Method') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">
                                        {{ $_model->payment_method ? $_model->payment_method->getLabel() : 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="fw-semibold fs-7 text-gray-600 mb-1">{{ t('Coupon Code') }}</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $_model->coupon_code ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Order Information-->

                        <!--begin::Separator-->
                        <div class="separator separator-solid mb-6"></div>
                        <!--end::Separator-->

                        <!--begin::Order Items-->
                        <div class="mb-8">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <h4 class="fw-bold text-gray-800 mb-3">{{ t('Order Items') }}</h4>
                                </div>
                            </div>
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-75px">{{ t('ID') }}</th>
                                            <th class="min-w-100px">{{ t('Image') }}</th>
                                            <th class="min-w-200px">{{ t('Product Name') }}</th>
                                            <th class="min-w-100px text-end">{{ t('Quantity') }}</th>
                                            <th class="min-w-100px text-end">{{ t('Price') }}</th>
                                            <th class="min-w-100px text-end">{{ t('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @forelse($_model->items as $item)
                                            <tr>
                                                <td class="text-gray-800">{{ $item->id }}</td>
                                                <td>
                                                    @if($item->product && $item->product->image_path)
                                                        <div class="symbol symbol-50px me-2">
                                                            <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name ?? 'Product' }}" class="symbol-label" style="object-fit: cover;" />
                                                        </div>
                                                    @else
                                                        <div class="symbol symbol-50px me-2">
                                                            <div class="symbol-label bg-light">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-gray-800">
                                                    {{ $item->product->name ?? 'N/A' }}
                                                </td>
                                                <td class="text-gray-800 text-end">{{ number_format($item->quantity, 0) }}</td>
                                                <td class="text-gray-800 text-end">{{ number_format($item->price, 2) }}</td>
                                                <td class="text-gray-800 text-end fw-bold">{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-gray-500">{{ t('No items found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Order Items-->

                        <!--begin::Separator-->
                        <div class="separator separator-solid mb-6"></div>
                        <!--end::Separator-->

                        <!--begin::Pricing Summary-->
                        <div class="mb-0">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <h4 class="fw-bold text-gray-800 mb-3">{{ t('Pricing Summary') }}</h4>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end flex-column">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold fs-6 text-gray-600">{{ t('Sub Total') }}</div>
                                    <div class="text-end fw-bold fs-6 text-gray-800">
                                        {{ number_format($_model->sub_total ?? 0, 2) }}
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold fs-6 text-gray-600">{{ t('Delivery Fee') }}</div>
                                    <div class="text-end fw-bold fs-6 text-gray-800">
                                        {{ number_format($_model->delivery_fee ?? 0, 2) }}
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold fs-6 text-gray-600">{{ t('Total Before Discount') }}</div>
                                    <div class="text-end fw-bold fs-6 text-gray-800">
                                        {{ number_format($_model->total_price_before_discount ?? 0, 2) }}
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold fs-6 text-gray-600">{{ t('Discount') }}</div>
                                    <div class="text-end fw-bold fs-6 text-danger">
                                        -{{ number_format($_model->discount ?? 0, 2) }}
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Separator-->
                                <div class="separator separator-solid my-5"></div>
                                <!--end::Separator-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack">
                                    <div class="fw-bold fs-6 text-gray-800 fs-2xl">{{ t('Total Price After Discount') }}</div>
                                    <div class="text-end fw-bold fs-6 text-success fs-2xl">
                                        {{ number_format($_model->total_price_after_discount ?? 0, 2) }}
                                    </div>
                                </div>
                                <!--end::Item-->
                            </div>
                        </div>
                        <!--end::Pricing Summary-->
                    </div>
                    <!--end::Invoice 2-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Invoice-->
</div>
<!--end::Modal body-->

@push('styles')
<style>
    @media print {
        .modal-header,
        .modal-footer,
        .btn_print_order {
            display: none !important;
        }
        .modal-dialog {
            max-width: 100% !important;
            margin: 0 !important;
        }
        .modal-content {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            margin: 0;
            padding: 20px;
        }
    }
</style>
@endpush

