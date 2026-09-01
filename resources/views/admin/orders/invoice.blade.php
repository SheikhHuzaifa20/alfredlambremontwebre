<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>

    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; line-height: 1.4; margin: 0; padding: 20px; }
        .header-table { width: 100%; border: none; margin-bottom: 20px; }
        .header-table td { border: none; padding: 0; vertical-align: top; }
        .company-info { text-align: right; }
        .invoice-title { font-size: 24px; font-weight: bold; color: #1d2452; margin: 0 0 5px 0; }
        .meta-text { font-size: 11px; color: #666; }
        hr { border: none; border-top: 1px solid #ddd; margin: 15px 0; }
        .address-table { width: 100%; border: none; margin-bottom: 20px; }
        .address-table td { border: none; padding: 0; vertical-align: top; width: 50%; }
        .section-heading { font-weight: bold; font-size: 11px; text-transform: uppercase; color: #888; margin-bottom: 5px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items-table th, .items-table td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        .items-table th { background: #f8fafc; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .text-right { text-align: right !important; }
        .totals-table { width: 45%; margin-left: auto; margin-top: 20px; border-collapse: collapse; }
        .totals-table td, .totals-table th { border: 1px solid #e2e8f0; padding: 8px 12px; }
        .totals-table th { background: #f8fafc; text-align: left; }
        .grand-total { font-weight: bold; font-size: 14px; color: #1d2452; }
        .footer { margin-top: 40px; font-size: 11px; color: #777; text-align: center; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>

<body>

{{-- Header --}}
<table class="header-table">
    <tr>
        <td>
            <div class="invoice-title">INVOICE</div>
            <div class="meta-text">
                <strong>Order #:</strong> {{ $order->id }}<br>
                <strong>Date:</strong> {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}<br>
                <strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}<br>
                <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
            </div>
        </td>
        <td class="company-info">
            <strong style="font-size:16px; color:#1d2452;">Alfred Lambremont Webre</strong><br>
            <span class="meta-text">
                Customer Support<br>
                Email: {{ $order->order_email ?? 'support@alfredlambremontwebre.com' }}
            </span>
        </td>
    </tr>
</table>

<hr>

{{-- Customer & Shipping Details --}}
@php
    $customerName = $order->user->name ?? trim(($order->delivery_first_name ?? '') . ' ' . ($order->delivery_last_name ?? '')) ?: 'Guest Customer';
    $customerEmail = $order->user->email ?? $order->order_email ?? 'N/A';
    $customerPhone = $order->user->phone ?? $order->delivery_phone_no ?? 'N/A';

    $shippingStreet = $order->shippingAddress->street ?? ($order->delivery_address_1 ?? 'N/A');
    $shippingCity = $order->shippingAddress->city ?? ($order->delivery_city ?? '');
    $shippingState = $order->shippingAddress->state ?? ($order->delivery_state ?? '');
    $shippingZip = $order->shippingAddress->zip ?? ($order->delivery_zip_code ?? '');
    $shippingCountry = $order->shippingAddress->country ?? ($order->delivery_country ?? '');
@endphp

<table class="address-table">
    <tr>
        <td>
            <div class="section-heading">Billed / Customer Info</div>
            <strong>{{ $customerName }}</strong><br>
            Email: {{ $customerEmail }}<br>
            Phone: {{ $customerPhone }}
        </td>
        <td>
            <div class="section-heading">Shipping Address</div>
            <strong>{{ $customerName }}</strong><br>
            {{ $shippingStreet }}<br>
            {{ $shippingCity }}{{ $shippingState ? ', ' . $shippingState : '' }} {{ $shippingZip }}<br>
            {{ $shippingCountry }}
        </td>
    </tr>
</table>

{{-- Books Table --}}
<table class="items-table">
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 55%;">Book Description</th>
            <th class="text-right" style="width: 12%;">Price</th>
            <th class="text-right" style="width: 10%;">Qty</th>
            <th class="text-right" style="width: 18%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php $calcSubtotal = 0; @endphp
        @foreach($order->order_products as $item)
            @php
                $itemName = $item->order_products_name ?? $item->product?->name ?? 'Book';
                $itemPrice = $item->order_products_price ?? $item->product?->price ?? 0;
                $itemQty = $item->order_products_qty ?? 1;
                $itemSubtotal = $item->order_products_subtotal ?? ($itemPrice * $itemQty);
                $calcSubtotal += $itemSubtotal;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $itemName }}</strong>
                    @if($item->mat_language)
                        <br><span style="font-size: 10px; color: #666;">Format: {{ $item->mat_language }}</span>
                    @endif
                </td>
                <td class="text-right">${{ number_format($itemPrice, 2) }}</td>
                <td class="text-right">{{ $itemQty }}</td>
                <td class="text-right">${{ number_format($itemSubtotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Totals Table --}}
@php
    $finalSubtotal = $order->order_item_total ?? $calcSubtotal;
    $shippingFee = $order->order_shipping ?? $order->shipping_tax ?? 0.00;
    $grandTotal = $order->order_total ?? ($finalSubtotal + $shippingFee);
@endphp

<table class="totals-table">
    <tr>
        <th>Subtotal</th>
        <td class="text-right">${{ number_format($finalSubtotal, 2) }}</td>
    </tr>
    <tr>
        <th>Shipping / Tax</th>
        <td class="text-right">${{ number_format($shippingFee, 2) }}</td>
    </tr>
    <tr>
        <th>Total</th>
        <td class="text-right grand-total">${{ number_format($grandTotal, 2) }}</td>
    </tr>
</table>

<div class="footer">
    Thank you for shopping with Alfred Lambremont Webre!
</div>

</body>
</html>
