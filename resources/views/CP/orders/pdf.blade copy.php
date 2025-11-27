<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : 'ltr' }}" lang="{{ lang() }}">

<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0; padding:20px; font-family:'DejaVu Sans', Arial, sans-serif; font-size:10pt; color:#1f2937; direction: {{ isRtl() ? 'rtl' : 'ltr' }}; line-height:1.5; background-color:#ffffff;">

    <!-- Header Section -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:25px; background-color:#1e40af;">
        <tr>
            <td style="padding:30px 20px; text-align:center; background-color:#1e40af;">
                <div style="font-size:26pt; color:#ffffff; font-weight:bold; margin:0 0 12px 0; letter-spacing:0.5px;">
                    {{ t('Order Details') }}
                </div>
                <div style="font-size:20pt; color:#fbbf24; font-weight:bold; margin:0 0 10px 0;">
                    #{{ $_model->id }}
                </div>
                <div style="font-size:10pt; color:#ffffff; margin:0; opacity:0.85;">
                    {{ t('Created At') }}: {{ $_model->created_at ? $_model->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Customer Information Section -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #d1d5db;">
        <tr>
            <td colspan="2" style="background-color:#1e40af; color:#ffffff; font-size:13pt; font-weight:bold; padding:14px 15px;">
                {{ t('Customer Information') }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="width:35%; font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Full Name') }}
            </td>
            <td style="width:65%; padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ trim(($_model->first_name ?? '') . ' ' . ($_model->last_name ?? '')) ?: 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Phone') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->phone ?? 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Email') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->email ?? 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Region') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->region->name ?? 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Address') }}
            </td>
            <td style="padding:14px 15px; color:#111827; font-size:11pt;">
                {{ $_model->address ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- Order Information Section -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #d1d5db;">
        <tr>
            <td colspan="2" style="background-color:#1e40af; color:#ffffff; font-size:13pt; font-weight:bold; padding:14px 15px;">
                {{ t('Order Information') }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="width:35%; font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Status') }}
            </td>
            <td style="width:65%; padding:14px 15px; border-bottom:1px solid #e5e7eb;">
                @php
                    $color = '#fef3c7';
                    $text = '#92400e';
                    if ($_model->status) {
                        $map = [
                            'warning' => ['#fef3c7', '#92400e'],
                            'info' => ['#dbeafe', '#1e40af'],
                            'success' => ['#d1fae5', '#065f46'],
                            'danger' => ['#fee2e2', '#991b1b'],
                        ];
                        [$color, $text] = $map[$_model->status->getColor()] ?? [$color, $text];
                    }
                @endphp
                @if ($_model->status)
                    <span style="display:inline-block; padding:8px 16px; border-radius:4px; font-size:10pt; font-weight:bold; background-color:{{ $color }}; color:{{ $text }};">
                        {{ $_model->status->getLabel() }}
                    </span>
                @else
                    <span style="display:inline-block; padding:8px 16px; border-radius:4px; font-size:10pt; font-weight:bold; background-color:#fef3c7; color:#92400e;">
                        {{ t('Pending') }}
                    </span>
                @endif
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Delivery Method') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->delivery_method ? $_model->delivery_method->getLabel() : 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Payment Method') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->payment_method ? $_model->payment_method->getLabel() : 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Coupon Code') }}
            </td>
            <td style="padding:14px 15px; border-bottom:1px solid #e5e7eb; color:#111827; font-size:11pt;">
                {{ $_model->coupon_code ?? 'N/A' }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="font-weight:bold; color:#374151; padding:14px 15px; border-right:1px solid #d1d5db; font-size:11pt;">
                {{ t('Read Conditions') }}
            </td>
            <td style="padding:14px 15px; color:#111827; font-size:11pt;">
                {{ $_model->read_conditions ? t('Yes') : t('No') }}
            </td>
        </tr>
    </table>

    <!-- Order Items Section -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px; border:1px solid #d1d5db;">
        <tr>
            <td colspan="5" style="background-color:#1e40af; color:#ffffff; font-size:13pt; font-weight:bold; padding:14px 15px;">
                {{ t('Order Items') }}
            </td>
        </tr>
        <tr style="background-color:#eff6ff;">
            <th style="width:8%; padding:14px 10px; text-align:{{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:11pt; border-bottom:2px solid #1e40af; border-right:1px solid #cbd5e1; color:#111827;">
                #
            </th>
            <th style="width:40%; padding:14px 10px; text-align:{{ isRtl() ? 'right' : 'left' }}; font-weight:bold; font-size:11pt; border-bottom:2px solid #1e40af; border-right:1px solid #cbd5e1; color:#111827;">
                {{ t('Product Name') }}
            </th>
            <th style="width:15%; padding:14px 10px; text-align:center; font-weight:bold; font-size:11pt; border-bottom:2px solid #1e40af; border-right:1px solid #cbd5e1; color:#111827;">
                {{ t('Quantity') }}
            </th>
            <th style="width:18%; padding:14px 10px; text-align:right; font-weight:bold; font-size:11pt; border-bottom:2px solid #1e40af; border-right:1px solid #cbd5e1; color:#111827;">
                {{ t('Price') }}
            </th>
            <th style="width:19%; padding:14px 10px; text-align:right; font-weight:bold; font-size:11pt; border-bottom:2px solid #1e40af; color:#111827;">
                {{ t('Total') }}
            </th>
        </tr>
        @forelse($_model->items as $index => $item)
            <tr style="background-color:{{ $index % 2 == 0 ? '#ffffff' : '#f9fafb' }};">
                <td style="padding:14px 10px; border-bottom:1px solid #e5e7eb; border-right:1px solid #e5e7eb; font-size:11pt; text-align:{{ isRtl() ? 'right' : 'left' }}; color:#6b7280;">
                    {{ $loop->iteration }}
                </td>
                <td style="padding:14px 10px; border-bottom:1px solid #e5e7eb; border-right:1px solid #e5e7eb; font-size:11pt; text-align:{{ isRtl() ? 'right' : 'left' }}; color:#111827; font-weight:600;">
                    {{ $item->product->name ?? 'N/A' }}
                </td>
                <td style="padding:14px 10px; border-bottom:1px solid #e5e7eb; border-right:1px solid #e5e7eb; font-size:11pt; text-align:center; color:#111827; font-weight:700;">
                    {{ number_format($item->quantity, 0) }}
                </td>
                <td style="padding:14px 10px; border-bottom:1px solid #e5e7eb; border-right:1px solid #e5e7eb; font-size:11pt; text-align:right; color:#6b7280;">
                    {{ number_format($item->price, 2) }}
                </td>
                <td style="padding:14px 10px; border-bottom:1px solid #e5e7eb; font-size:11pt; text-align:right; font-weight:bold; color:#111827;">
                    {{ number_format($item->total, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="padding:25px; border-bottom:1px solid #e5e7eb; font-size:11pt; text-align:center; color:#9ca3af; background-color:#f9fafb;">
                    {{ t('No items found') }}
                </td>
            </tr>
        @endforelse
    </table>

    <!-- Pricing Summary Section -->
    <table style="width:100%; border-collapse:collapse; margin-top:25px; border:1px solid #d1d5db;">
        <tr>
            <td colspan="2" style="background-color:#1e40af; color:#ffffff; font-size:13pt; font-weight:bold; padding:14px 15px;">
                {{ t('Pricing Summary') }}
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="width:70%; padding:16px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-weight:700; font-size:11pt; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; color:#374151;">
                {{ t('Sub Total') }}
            </td>
            <td style="width:30%; padding:16px 15px; text-align:right; font-size:12pt; border-bottom:1px solid #e5e7eb; color:#111827; font-weight:700;">
                {{ number_format($_model->sub_total ?? 0, 2) }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="padding:16px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-weight:700; font-size:11pt; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; color:#374151;">
                {{ t('Delivery Fee') }}
            </td>
            <td style="padding:16px 15px; text-align:right; font-size:12pt; border-bottom:1px solid #e5e7eb; color:#111827; font-weight:700;">
                {{ number_format($_model->delivery_fee ?? 0, 2) }}
            </td>
        </tr>
        <tr style="background-color:#f9fafb;">
            <td style="padding:16px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-weight:700; font-size:11pt; border-bottom:1px solid #e5e7eb; border-right:1px solid #d1d5db; color:#374151;">
                {{ t('Total Before Discount') }}
            </td>
            <td style="padding:16px 15px; text-align:right; font-size:12pt; border-bottom:1px solid #e5e7eb; color:#111827; font-weight:700;">
                {{ number_format($_model->total_price_before_discount ?? 0, 2) }}
            </td>
        </tr>
        <tr style="background-color:#ffffff;">
            <td style="padding:16px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-weight:700; font-size:11pt; border-bottom:3px solid #1e40af; border-right:1px solid #d1d5db; color:#374151;">
                {{ t('Discount') }}
            </td>
            <td style="padding:16px 15px; text-align:right; font-size:12pt; border-bottom:3px solid #1e40af; color:#dc2626; font-weight:bold;">
                -{{ number_format($_model->discount ?? 0, 2) }}
            </td>
        </tr>
        <tr style="background-color:#d1fae5;">
            <td style="padding:20px 15px; text-align:{{ isRtl() ? 'left' : 'right' }}; font-weight:bold; font-size:14pt; border-right:1px solid #86efac; color:#065f46;">
                {{ t('Total Price After Discount') }}
            </td>
            <td style="padding:20px 15px; text-align:right; font-weight:bold; font-size:16pt; color:#065f46;">
                {{ number_format($_model->total_price_after_discount ?? 0, 2) }}
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div style="margin-top:35px; padding-top:20px; border-top:2px solid #e5e7eb; text-align:center; font-size:9pt; color:#9ca3af; line-height:1.6;">
        <p style="margin:0; font-weight:600; color:#4b5563;">{{ t('Thank you for your order!') }}</p>
    </div>

</body>

</html>