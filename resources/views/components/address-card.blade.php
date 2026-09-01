@props(['title' => 'Address', 'address' => null, 'order' => null])

@php
    $recipient = $address->recipient ?? (trim(($order->delivery_first_name ?? '') . ' ' . ($order->delivery_last_name ?? '')) ?: 'N/A');
    $street = $address->street ?? ($order->delivery_address_1 ?? 'N/A');
    $city = $address->city ?? ($order->delivery_city ?? 'N/A');
    $state = $address->state ?? ($order->delivery_state ?? '');
    $zip = $address->zip ?? ($order->delivery_zip_code ?? '');
    $country = $address->country ?? ($order->delivery_country ?? 'N/A');
@endphp

<div class="card address-card mb-3">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold text-uppercase mb-0">{{ $title }}</h6>

            @if($address)
                <button
                    class="btn btn-sm btn-outline-primary edit-address"
                    data-id="{{ $address->id }}"
                    data-address='@json($address)'
                >
                    Edit
                </button>
            @endif
        </div>

        <div class="small text-muted">
            <div class="fw-semibold text-dark">{{ $recipient }}</div>
            <div>{{ $street }}</div>
            <div>{{ $city }}{{ $state ? ', ' . $state : '' }}</div>
            <div>{{ $zip ? $zip . ', ' : '' }}{{ $country }}</div>
        </div>

    </div>
</div>
