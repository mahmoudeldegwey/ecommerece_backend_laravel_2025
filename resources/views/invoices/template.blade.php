<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoiceNumber }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            text-align: right;
            margin-top: -50px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead {
            background-color: #f0f0f0;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 30px;
            float: right;
            width: 300px;
        }
        .totals table {
            margin-top: 0;
        }
        .totals td {
            border-bottom: none;
            padding: 8px;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 80px;
            text-align: center;
            font-size: 12px;
            color: #666;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{setting('website_name')}}</div>
        <!-- <div>123 Business St, City, Country</div> -->
        <div>
            Email:
            {{!is_null(setting('email')) ? ' | Email: '.  setting('email') : "" }}
            {{!is_null(setting('phone_number')) ? ' | Phone: '.   setting('phone_number') : "" }}
        </div>
        <div class="invoice-title">INVOICE</div>
    </div>
    
    <div style="overflow: hidden;">
        <!-- <div style="float: left; width: 48%;" class="info-section">
            <h3>Bill To:</h3>
            <div><strong>{{ $order->customer_name }}</strong></div>
            <div>{{ $order->customer_email }}</div>
            <div>{{ $order->customer_address }}</div>
            @if($order->billing_address)
                <div>{{ $order->billing_address }}</div>
            @endif
        </div> -->

        <div style="float: right; width: 48%; text-align: right;" class="info-section">
            <h3>Invoice Details:</h3>
            <div><strong>Order #:</strong> {{ $order->order_number }}</div>
            <div><strong>Order Status:</strong> {{ strtoupper($order->status) }}</div>
            <div><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</div>
            <div><strong>Payment Method:</strong> {{ $order->payment_method }}</div>
            <div><strong>Price:</strong> {{ $order->final_cost }}</div>
            <div> {{$order->coupon_applied ? 'Discount: '. $order->discount_price : '' }} </div>

        </div>
    
        {{-- Parse addresses using helper --}}
    @php
        $billingAddress = parseBillingAddress($order->billing_address);
    @endphp

    {{-- Address Section --}}

        {{-- Show both addresses when different --}}
        <div class="two-columns">
                @if($order->use_different_billing_address)
            <div class="column column-left address-section">
                <h3>Billing Address</h3>
                <div class="address-box">
                    <div><strong>{{ $billingAddress['username'] ?? '' }}</strong></div>
                    @if(isset($billingAddress['phone']))
                        <div>Phone: {{ $billingAddress['phone'] }}</div>
                    @endif
                    @if(isset($billingAddress['address']))
                        <div>{{ $billingAddress['address'] }}</div>
                    @endif
                    <div>
                        @if(isset($billingAddress['city_id']))
                            , {{ getCountryName($billingAddress['city_id']) }}
                        @endif
                        @if(isset($billingAddress['city_id']))
                            , {{ getCountryName($billingAddress['country_id']) }}
                        @endif
                    </div>
                </div>
            </div>
            @endif
            <div class="column address-section">
                <h3>Shipping Address</h3>
                <div class="address-box">
                    <div><strong>{{ $order->customer_name }}</strong></div>
                    <div>Phone: {{$order->customer_phone  }}</div>
                    <div>{{$order->customer_address  }}</div>
                    <div>
                        {{ getCityName($order->city_id) ?? '' }}
                            , {{ getCountryName($order->country_id) }}
                    </div>
                </div>
            </div>
        </div>

    </div>




    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
                @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->sku }}</td>
                <td class="text-right">{{ $item->product_quantity }}</td>
                
                <td class="text-right">
{{$item->product->sale_price != null ? $item->product->sale_price : $item->product->price }}
                </td>

                <td class="text-right">
                {{($item->product->sale_price != null ? $item->product->sale_price : $item->product->price) * $item->product_quantity }}

                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ formatCurrency($order->total_price) }}</td>
            </tr>
            @if($order->shipping_cost > 0)
            <tr>
                <td>Shipping Cost:</td>
                <td class="text-right">{{ formatCurrency($order->shipping_cost) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total:</td>
                <td class="text-right">{{ formatCurrency($order->final_cost) }}</td>
            </tr>
        </table>
    </div>
<!-- 
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>If you have any questions, please contact us at info@yourcompany.com</p>
    </div> -->
</body>
</html>