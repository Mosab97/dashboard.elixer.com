<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة طلب التوصيل - {{ $invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            direction: rtl;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .invoice-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 18px;
            color: #666;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .info-box {
            flex: 1;
            min-width: 300px;
            margin: 10px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-right: 4px solid #007bff;
        }

        .info-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
        }

        .items-table th {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .total-section {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .code-section {
            background: #d4edda;
            border: 2px solid #28a745;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }

        .code-title {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }

        .code-value {
            font-size: 32px;
            font-weight: bold;
            color: #155724;
            letter-spacing: 3px;
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 2px dashed #28a745;
            margin: 10px 0;
        }

        .code-expiry {
            color: #6c757d;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }

        .instructions {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .instructions h4 {
            color: #856404;
            margin-bottom: 10px;
        }

        .instructions ul {
            color: #856404;
            margin: 0;
            padding-right: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">مركز قيس العميري التعليمي</div>
            <div class="invoice-title">فاتورة طلب التوصيل</div>
            <div class="invoice-number">رقم الفاتورة: {{ $invoice_number }}</div>
        </div>

        <!-- Information Section -->
        <div class="info-section">
            <!-- Student Information -->
            <div class="info-box">
                <div class="info-title">معلومات الطالب</div>
                <div class="info-item">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $student->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الهاتف:</span>
                    <span class="info-value">{{ $student->mobile_number }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">عنوان التوصيل:</span>
                    <span class="info-value">{{ $delivery_order->address }}</span>
                </div>
            </div>

            {{-- <!-- Sales Center Information -->
            <div class="info-box">
                <div class="info-title">معلومات مركز البيع</div>
                <div class="info-item">
                    <span class="info-label">اسم المركز:</span>
                    <span class="info-value">{{ $sales_center->name ?? 'مركز البيع' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الهاتف:</span>
                    <span class="info-value">{{ $sales_center->mobile_number }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الموقع:</span>
                    <span class="info-value">{{ $sales_center->location }}</span>
                </div>
            </div> --}}
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>النوع</th>
                    <th>السعر</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->class_type_text }}</td>
                        <td>{{ number_format($item->final, 2) }} د.ع</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div style="text-align: left;">
                <span style="font-size: 18px; font-weight: bold;">المجموع الكلي:</span>
                <span class="total-amount">{{ number_format($total_amount, 2) }} د.ع</span>
            </div>
        </div>
        @if ($subscription_code)
            <!-- Subscription Code Section -->
            <div class="code-section">
                <div class="code-title">كود الاشتراك</div>
                <div class="code-value">{{ $subscription_code->code }}</div>
                <div class="code-expiry">
                    ينتهي في: {{ $code_expires_at }}
                </div>
            </div>
        @endif
        <!-- Instructions -->
        <div class="instructions">
            <h4>تعليمات مهمة:</h4>
            <ul>
                <li>يجب تسليم هذه الفاتورة مع كود الاشتراك للطالب</li>
                <li>كود الاشتراك صالح لمدة 30 يوم من تاريخ الإنشاء</li>
                <li>عند استلام الكود، يجب على الطالب تفعيله من خلال التطبيق</li>
                {{-- <li>في حالة عدم استلام الكود، يرجى التواصل مع مركز البيع</li> --}}
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>تاريخ الفاتورة: {{ $invoice_date }}</p>
            <p>شكراً لاختياركم مركز قيس العميري التعليمي</p>
        </div>
    </div>
</body>

</html>
