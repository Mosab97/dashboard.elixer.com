<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : 'ltr' }}" lang="{{ lang() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ t('Order') }} #{{ $_model->id }}</title>
</head>

<body style="margin:0; padding:10px; font-family:'DejaVu Sans', Arial, sans-serif; font-size:10pt; color:#333333; direction: {{ isRtl() ? 'rtl' : 'ltr' }};">

    <!-- Header Section -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-bottom:20px;">
        <tr>
            <td style="text-align:center; padding:0 0 15px 0; border-bottom:3px solid #333333;">
                <img src="{{ public_path('media/logos/logo.png') }}" alt="Logo" style="width:120px; height:auto;">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; padding:15px 0 0 0;">
                <div style="font-size:20pt; font-weight:bold; color:#333333; margin:0 0 8px 0;">
                    {{ t('Order Details') }}
                </div>
                <div style="font-size:14pt; color:#666666; margin:0 0 5px 0;">
                    {{ t('Invoice Number') }}: #{{ $_model->id }}
                </div>
                <div style="font-size:9pt; color:#999999; margin:0;">
                    {{ t('Created At') }}: {{ $_model->created_at ? $_model->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Customer Information Section -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #cccccc;">
        <tr>
            <td colspan="2" bgcolor="#f8f9fa" style="padding:10px 15px; font-size:12pt; font-weight:bold; color:#333333; border-bottom:2px solid #555555;">
                {{ t('Customer Information') }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="width:35%; padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Full Name') }}:
            </td>
            <td bgcolor="#ffffff" style="width:65%; padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ trim(($_model->first_name ?? '') . ' ' . ($_model->last_name ?? '')) ?: 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Phone') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->phone ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Email') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->email ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Region') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->region->name ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt;">
                {{ t('Address') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt;">
                {{ $_model->address ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Order Information Section -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #cccccc;">
        <tr>
            <td colspan="2" bgcolor="#f8f9fa" style="padding:10px 15px; font-size:12pt; font-weight:bold; color:#333333; border-bottom:2px solid #555555;">
                {{ t('Order Information') }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="width:35%; padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Status') }}:
            </td>
            <td bgcolor="#ffffff" style="width:65%; padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                @php
                    $statusBg = '#e9ecef';
                    $statusText = '#333333';
                    if ($_model->status) {
                        $statusMap = [
                            'warning' => ['#fff3cd', '#856404'],
                            'info' => ['#d1ecf1', '#0c5460'],
                            'success' => ['#d4edda', '#155724'],
                            'danger' => ['#f8d7da', '#721c24'],
                        ];
                        [$statusBg, $statusText] = $statusMap[$_model->status->getColor()] ?? [$statusBg, $statusText];
                    }
                @endphp
                <strong style="padding:4px 10px; font-size:9pt; font-weight:bold; background-color:{{ $statusBg }}; color:{{ $statusText }};">
                    {{ $_model->status ? $_model->status->getLabel() : t('Pending') }}
                </strong>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Delivery Method') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->delivery_method ? $_model->delivery_method->getLabel() : 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Payment Method') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->payment_method ? $_model->payment_method->getLabel() : 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ t('Coupon Code') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt; border-bottom:1px solid #e0e0e0;">
                {{ $_model->coupon_code ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#f8f9fa" style="padding:10px 15px; font-weight:bold; color:#555555; font-size:10pt;">
                {{ t('Read Conditions') }}:
            </td>
            <td bgcolor="#ffffff" style="padding:10px 15px; color:#333333; font-size:10pt;">
                {{ $_model->read_conditions ? t('Yes') : t('No') }}
            </td>
        </tr>
    </table>

    <!-- Order Items Section -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #cccccc;">
        <thead>
            <tr bgcolor="#333333" style="color:#ffffff;">
                <th style="width:8%; padding:10px 8px; text-align:{{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:10pt;">
                    #
                </th>
                <th style="width:40%; padding:10px 8px; text-align:{{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:10pt;">
                    {{ t('Product Name') }}
                </th>
                <th style="width:15%; padding:10px 8px; text-align:center; font-weight:bold; font-size:10pt;">
                    {{ t('Quantity') }}
                </th>
                <th style="width:18%; padding:10px 8px; text-align:center; font-weight:bold; font-size:10pt;">
                    {{ t('Price') }}
                </th>
                <th style="width:19%; padding:10px 8px; text-align:center; font-weight:bold; font-size:10pt;">
                    {{ t('Total') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($_model->items as $index => $item)
                <tr bgcolor="{{ $index % 2 == 0 ? '#ffffff' : '#f8f9fa' }}">
                    <td style="padding:10px 8px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:{{ isRtl() ? 'right' : 'left' }}; color:#666666;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="padding:10px 8px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:{{ isRtl() ? 'right' : 'left' }}; color:#333333; font-weight:600;">
                        {{ $item->product->name ?? 'N/A' }}
                    </td>
                    <td style="padding:10px 8px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:center; color:#333333; font-weight:bold;">
                        {{ number_format($item->quantity, 0) }}
                    </td>
                    <td style="padding:10px 8px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:center; color:#666666;">
                        {{ number_format($item->price, 2) }}
                    </td>
                    <td style="padding:10px 8px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:center; font-weight:bold; color:#333333;">
                        {{ number_format($item->total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" bgcolor="#f8f9fa" style="padding:20px; border-bottom:1px solid #e0e0e0; font-size:10pt; text-align:center; color:#999999;">
                        {{ t('No items found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pricing Summary Section -->
    <table cellpadding="0" cellspacing="0" bgcolor="#e9ecef" style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #cccccc;">
        <tr>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:10pt; color:#555555; border-bottom:1px solid #d0d0d0;">
                {{ t('Sub Total') }}:
            </td>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:11pt; font-weight:bold; color:#333333; border-bottom:1px solid #d0d0d0;">
                {{ number_format($_model->sub_total ?? 0, 2) }}
            </td>
        </tr>
        <tr>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:10pt; color:#555555; border-bottom:1px solid #d0d0d0;">
                {{ t('Delivery Fee') }}:
            </td>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:11pt; font-weight:bold; color:#333333; border-bottom:1px solid #d0d0d0;">
                {{ number_format($_model->delivery_fee ?? 0, 2) }}
            </td>
        </tr>
        <tr>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:10pt; color:#555555; border-bottom:1px solid #d0d0d0;">
                {{ t('Total Before Discount') }}:
            </td>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:11pt; font-weight:bold; color:#333333; border-bottom:1px solid #d0d0d0;">
                {{ number_format($_model->total_price_before_discount ?? 0, 2) }}
            </td>
        </tr>
        <tr>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:10pt; color:#555555; border-bottom:2px solid #333333;">
                {{ t('Discount') }}:
            </td>
            <td style="padding:10px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:11pt; font-weight:bold; color:#dc3545; border-bottom:2px solid #333333;">
                -{{ number_format($_model->discount ?? 0, 2) }}
            </td>
        </tr>
        <tr bgcolor="#d4d4d4">
            <td style="padding:15px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:12pt; font-weight:bold; color:#333333;">
                {{ t('Total Price After Discount') }}:
            </td>
            <td style="padding:15px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-size:14pt; font-weight:bold; color:#333333;">
                {{ number_format($_model->total_price_after_discount ?? 0, 2) }}
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-top:20px; border-top:2px solid #cccccc;">
        <tr>
            <td style="padding:15px 0 5px 0; text-align:center; font-size:9pt; color:#999999;">
                {{ t('Invoice Date') }}: {{ $_model->created_at ? $_model->created_at->format('Y-m-d') : date('Y-m-d') }}
            </td>
        </tr>
        <tr>
            <td style="padding:5px 0 10px 0; text-align:center; font-size:10pt; font-weight:bold; color:#333333;">
                {{ t('Thank you for your order!') }}
            </td>
        </tr>
    </table>

</body>

</html>