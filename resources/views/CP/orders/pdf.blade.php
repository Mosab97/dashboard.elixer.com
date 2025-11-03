<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : 'ltr' }}" lang="{{ lang() }}">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:20px; font-family:'DejaVu Sans', Arial, sans-serif; font-size:10pt; color:#333; direction: {{ isRtl() ? 'rtl' : 'ltr' }}; line-height:1.5;">

    <!-- Header -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:15px;">
        <tr>
            <td style="text-align:center;">
                <div style="font-size:18pt; color:#1e3a8a; font-weight:bold;">{{ t('Order Details') }} - #{{ $_model->id }}</div>
                <div style="font-size:9pt; color:#666; margin-top:6px;">{{ t('Created At') }}: {{ $_model->created_at ? $_model->created_at->format('Y-m-d H:i:s') : 'N/A' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="border-top:1px solid #ddd; height:0; margin:12px 0 8px 0;"></div>
            </td>
        </tr>
    </table>

    <!-- Customer Information -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
        <tr>
            <td colspan="2" style="font-size:12pt; font-weight:bold; color:#1e3a8a; padding:6px 0; border-bottom:1px solid #e5e7eb;">{{ t('Customer Information') }}</td>
        </tr>
        <tr>
            <td style="width:25%; font-weight:bold; color:#666; padding:6px 4px; vertical-align:top;">{{ t('Full Name') }}</td>
            <td style="width:75%; padding:6px 4px;">{{ trim(($_model->first_name ?? '') . ' ' . ($_model->last_name ?? '')) ?: 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px; vertical-align:top;">{{ t('Phone') }}</td>
            <td style="padding:6px 4px;">{{ $_model->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px; vertical-align:top;">{{ t('Email') }}</td>
            <td style="padding:6px 4px;">{{ $_model->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px; vertical-align:top;">{{ t('Region') }}</td>
            <td style="padding:6px 4px;">{{ $_model->region->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px; vertical-align:top;">{{ t('Address') }}</td>
            <td style="padding:6px 4px;">{{ $_model->address ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Order Information -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
        <tr>
            <td colspan="4" style="font-size:12pt; font-weight:bold; color:#1e3a8a; padding:6px 0; border-bottom:1px solid #e5e7eb;">{{ t('Order Information') }}</td>
        </tr>
        <tr>
            <td style="width:25%; font-weight:bold; color:#666; padding:6px 4px;">{{ t('Status') }}</td>
            <td style="width:25%; padding:6px 4px;">
                @php
                    $color = '#fef3c7'; $text = '#92400e';
                    if ($_model->status) {
                        $map = [
                            'warning' => ['#fef3c7','#92400e'],
                            'info' => ['#dbeafe','#1e40af'],
                            'success' => ['#d1fae5','#065f46'],
                            'danger' => ['#fee2e2','#991b1b']
                        ];
                        [$color, $text] = $map[$_model->status->getColor()] ?? [$color, $text];
                    }
                @endphp
                @if($_model->status)
                    <span style="display:inline-block; padding:4px 8px; border-radius:4px; font-size:8pt; font-weight:bold; background-color: {{ $color }}; color: {{ $text }};">{{ $_model->status->getLabel() }}</span>
                @else
                    <span style="display:inline-block; padding:4px 8px; border-radius:4px; font-size:8pt; font-weight:bold; background-color:#fef3c7; color:#92400e;">{{ t('Pending') }}</span>
                @endif
            </td>
            <td style="width:25%; font-weight:bold; color:#666; padding:6px 4px;">{{ t('Delivery Method') }}</td>
            <td style="width:25%; padding:6px 4px;">{{ $_model->delivery_method ? $_model->delivery_method->getLabel() : 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px;">{{ t('Payment Method') }}</td>
            <td style="padding:6px 4px;">{{ $_model->payment_method ? $_model->payment_method->getLabel() : 'N/A' }}</td>
            <td style="font-weight:bold; color:#666; padding:6px 4px;">{{ t('Coupon Code') }}</td>
            <td style="padding:6px 4px;">{{ $_model->coupon_code ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold; color:#666; padding:6px 4px;">{{ t('Read Conditions') }}</td>
            <td style="padding:6px 4px;">{{ $_model->read_conditions ? t('Yes') : t('No') }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <!-- Order Items -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
        <tr>
            <td colspan="6" style="font-size:12pt; font-weight:bold; color:#1e3a8a; padding:6px 0; border-bottom:1px solid #e5e7eb;">{{ t('Order Items') }}</td>
        </tr>
    </table>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="width:8%; background-color:#f3f4f6; padding:6px; text-align: {{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('ID') }}</th>
                <th style="width:15%; background-color:#f3f4f6; padding:6px; text-align:center; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('Image') }}</th>
                <th style="width:35%; background-color:#f3f4f6; padding:6px; text-align: {{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('Product Name') }}</th>
                <th style="width:12%; background-color:#f3f4f6; padding:6px; text-align:right; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('Quantity') }}</th>
                <th style="width:15%; background-color:#f3f4f6; padding:6px; text-align:right; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('Price') }}</th>
                <th style="width:15%; background-color:#f3f4f6; padding:6px; text-align:right; font-weight:bold; font-size:9pt; border:1px solid #ddd;">{{ t('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($_model->items as $item)
                <tr>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt;">{{ $item->id }}</td>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt; text-align:center;">
                        @if($item->product && $item->product->image_path)
                            @php
                                $imagePath = $item->product->image_path;
                                if (str_starts_with($imagePath, 'http')) {
                                    $imagePath = str_replace(asset(''), '', $imagePath);
                                }
                                $fullPath = public_path($imagePath);
                            @endphp
                            @if(file_exists($fullPath))
                                <img src="{{ $fullPath }}" alt="{{ $item->product->name ?? 'Product' }}" style="width:45px; height:45px;" />
                            @else
                                <span style="color:#999;">-</span>
                            @endif
                        @else
                            <span style="color:#999;">-</span>
                        @endif
                    </td>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt;">{{ $item->product->name ?? 'N/A' }}</td>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt; text-align:right;">{{ number_format($item->quantity, 0) }}</td>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt; text-align:right;">{{ number_format($item->price, 2) }}</td>
                    <td style="padding:6px; border:1px solid #ddd; font-size:9pt; text-align:right;">{{ number_format($item->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:8px; border:1px solid #ddd; font-size:9pt; text-align:center;">{{ t('No items found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pricing Summary -->
    <table style="width:100%; border-collapse:collapse; margin-top:15px;">
        <tr>
            <td colspan="2" style="font-size:12pt; font-weight:bold; color:#1e3a8a; padding:6px 0; border-bottom:1px solid #e5e7eb;">{{ t('Pricing Summary') }}</td>
        </tr>
        <tr>
            <td style="width:70%; padding:6px 4px; text-align: {{ isRtl() ? 'left' : 'right' }}; font-weight:bold;">{{ t('Sub Total') }}</td>
            <td style="width:30%; padding:6px 4px; text-align:right;">{{ number_format($_model->sub_total ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:6px 4px; text-align: {{ isRtl() ? 'left' : 'right' }}; font-weight:bold;">{{ t('Delivery Fee') }}</td>
            <td style="padding:6px 4px; text-align:right;">{{ number_format($_model->delivery_fee ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:6px 4px; text-align: {{ isRtl() ? 'left' : 'right' }}; font-weight:bold;">{{ t('Total Before Discount') }}</td>
            <td style="padding:6px 4px; text-align:right;">{{ number_format($_model->total_price_before_discount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:6px 4px; text-align: {{ isRtl() ? 'left' : 'right' }}; font-weight:bold;">{{ t('Discount') }}</td>
            <td style="padding:6px 4px; text-align:right; color:#dc2626;">-{{ number_format($_model->discount ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td style="padding:10px 4px; text-align: {{ isRtl() ? 'left' : 'right' }}; font-weight:bold; font-size:14pt; border-top:2px solid #ddd;">{{ t('Total Price After Discount') }}</td>
            <td style="padding:10px 4px; text-align:right; font-weight:bold; font-size:14pt; color:#059669; border-top:2px solid #ddd;">{{ number_format($_model->total_price_after_discount ?? 0, 2) }}</td>
        </tr>
    </table>

</body>
</html>

