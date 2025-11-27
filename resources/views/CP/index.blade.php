@extends('CP.metronic.index')

@section('subpageTitle', t('Dashboard'))

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">{{ Setting::get('site_name', [])[lang()] ?? config('app.name', 'default') }} {{ t('CRM') }} </h3>

                </div>
                <div class="card-body">

                    <!-- Stats Cards -->
                    <div class="row g-5 g-xl-8 mb-5">
                        <!-- Categories Card -->
                        <div class="col-xl-4">
                            <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-primary fs-5 mb-3 d-block">{{ t('Categories') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($categoriesCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Total') }}</span>
                                    </div>
                                    <div class="py-1">
                                        <span
                                            class="text-success fs-1 fw-bold me-2">{{ number_format($activeCategoriesCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Active') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Card -->
                        <div class="col-xl-4">
                            <div class="card bg-light-info card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-info fs-5 mb-3 d-block">{{ t('Products') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($productsCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Total') }}</span>
                                    </div>
                                    <div class="py-1">
                                        <span
                                            class="text-success fs-1 fw-bold me-2">{{ number_format($activeProductsCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Active') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Success Stories Card -->
                        <div class="col-xl-4">
                            <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-info fs-5 mb-3 d-block">{{ t('Success Stories') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($sucessStoriesCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Total') }}</span>
                                    </div>
                                    <div class="py-1">
                                        <span
                                            class="text-success fs-1 fw-bold me-2">{{ number_format($activeSucessStoriesCount) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Active') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Statistics -->
                    <div class="row g-5 g-xl-8 mb-5">
                        <!-- Delivered Orders Card -->
                        <div class="col-xl-3">
                            <div class="card bg-light-success card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-success fs-5 mb-3 d-block">{{ t('Delivered Orders') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($deliveredOrdersCount ?? 0) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Orders') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Orders Card -->
                        <div class="col-xl-3">
                            <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-warning fs-5 mb-3 d-block">{{ t('New Orders') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($newOrdersCount ?? 0) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Orders') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Products Sold Card -->
                        <div class="col-xl-3">
                            <div class="card bg-light-info card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-info fs-5 mb-3 d-block">{{ t('Total Products Sold') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($totalProductsSold ?? 0) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Items') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Revenue Card -->
                        <div class="col-xl-3">
                            <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                                <div class="card-body my-3">
                                    <a href="#"
                                        class="card-title fw-bold text-primary fs-5 mb-3 d-block">{{ t('Total Revenue') }}</a>
                                    <div class="py-1">
                                        <span class="text-dark fs-1 fw-bold me-2">{{ number_format($totalRevenue ?? 0, 2) }}</span>
                                        <span class="fw-semibold text-muted fs-7">{{ t('Currency') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Most Requested Products -->
                    @if(isset($mostRequestedProducts) && $mostRequestedProducts->count() > 0)
                    <div class="row g-5 g-xl-8 mb-5">
                        <div class="col-xl-12">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title">{{ t('Most Requested Products') }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <thead>
                                                <tr class="fw-bold text-muted">
                                                    <th class="min-w-100px">{{ t('Product Name') }}</th>
                                                    <th class="min-w-100px text-end">{{ t('Total Quantity Sold') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mostRequestedProducts as $item)
                                                <tr>
                                                    <td>
                                                        <span class="text-gray-800 fw-bold">{{ $item->product->name ?? t('N/A') }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-light-primary fs-6">{{ number_format($item->total_quantity ?? 0) }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
