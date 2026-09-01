@extends('layouts.app')
@push('before-css')
    <style>
        /* ... existing styles ... */
    </style>
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">View Order</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Ecommerce</li>
                        <li class="breadcrumb-item active">Orders</li>
                        <li class="breadcrumb-item active">View Order</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-expanded="false">
                    Update Status
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                        <li><a class="dropdown-item changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="pending">Pending</a></li>
                        <li><a class="dropdown-item changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="in_process">In Process</a></li>
                        <li><a class="dropdown-item changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="shipped">Shipped</a></li>
                        <li><a class="dropdown-item changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="delivered">Delivered</a></li>
                        <li><a class="dropdown-item changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="returned">Returned</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger changeStatus" href="javascript:void(0)" data-id={{ $order->id }} data-status="canceled">Canceled</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        {{-- Top Row --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            {{-- Order Title --}}
                            <div>
                                <h4 class="fw-bold mb-1">
                                    Order #{{ $order->id }}
                                </h4>

                                <div class="text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                    <span class="mx-2">•</span>
                                    {{ $order->created_at->diffForHumans() }}
                                </div>
                            </div>

                            {{-- Status + Actions --}}
                            <div class="d-flex align-items-center mt-2 mt-md-0">

                                <span class="badge badge-{{ $badge['class'] }}
                                            d-inline-flex align-items-center
                                            px-1 py-1 mr-2"
                                    style="height:32px;" id="show-status">
                                    <i class="fas fa-{{ $badge['icon'] }} mr-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>

                                <a class="btn btn-sm btn-outline-secondary
                                        d-inline-flex align-items-center"
                                style="height:32px;"
                                href="{{ route('admin.orders.invoice', $order->id) }}"
                                target="_blank">
                                    <i class="fas fa-file-invoice mr-1"></i>
                                    Invoice
                                </a>

                            </div>

                        </div>

                        {{-- Meta Info Row --}}
                        <div class="row mt-3 text-sm">

                            <div class="col-md-3">
                                <div class="text-muted">Payment</div>
                                <div class="fw-semibold">
                                    {{ ucfirst($order->payment_method) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="text-muted">Total</div>
                                <div class="fw-semibold">
                                    ${{ number_format($order->order_total ?? 0, 2) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="text-muted">Items</div>
                                <div class="fw-semibold">
                                    {{ $order->order_products->sum('order_products_qty') }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="text-muted">Customer</div>
                                <div class="fw-semibold">
                                    {{-- ✅ SIRF delivery_first_name aur delivery_last_name se name --}}
                                    @php
                                        $firstName = $order->delivery_first_name ?? '';
                                        $lastName = $order->delivery_last_name ?? '';
                                        $customerName = trim($firstName . ' ' . $lastName);
                                    @endphp
                                    {{ !empty($customerName) ? $customerName : 'Guest Customer' }}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex m-b-10 no-block">
                            <h5 class="card-title m-b-0 align-self-center text-uppercase">Order Details</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table product-table color-table primary-table">
                                <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>Book</th>
                                        <th>Price</th>
                                        <th>QTY</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->order_products as $orderProduct)
                                        @php
                                            $pName = $orderProduct->order_products_name ?? $orderProduct->product?->name ?? 'Book';
                                            $pPrice = $orderProduct->order_products_price ?? $orderProduct->product?->price ?? 0;
                                            $pQty = $orderProduct->order_products_qty ?? 1;
                                            $pSubtotal = $orderProduct->order_products_subtotal ?? ($pPrice * $pQty);
                                        @endphp
                                        <tr>
                                            <td>{{ $orderProduct->product?->id ?? $orderProduct->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($orderProduct->product?->image)
                                                        <img src="{{ asset('uploads/product/'.$orderProduct->product->image) }}"
                                                            alt="{{ $pName }}" class="rounded me-2" width="40" height="40" style="object-fit:cover;">
                                                    @else
                                                        <img src="{{ asset('assets/imgs/default.png') }}"
                                                            alt="{{ $pName }}" class="rounded me-2" width="40" height="40" style="object-fit:cover;">
                                                    @endif
                                                    <div>
                                                        <span class="fw-semibold">{{ $pName }}</span>
                                                        @if($orderProduct->mat_language)
                                                            <div class="text-muted small">Format: {{ $orderProduct->mat_language }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($pPrice, 2) }}</td>
                                            <td>{{ $pQty }}</td>
                                            <td>${{ number_format($pSubtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row justify-content-end mt-4">
                                <div class="col-md-5">
                                    <table class="table table-borderless text-end">
                                        <tbody>
                                            <tr>
                                                <td class="fw-semibold">Subtotal:</td>
                                                <td>${{ number_format($order->order_item_total ?? 0, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Shipping / Tax:</td>
                                                <td>${{ number_format($order->order_shipping ?? 0.00, 2) }}</td>
                                            </tr>
                                            <tr class="border-top">
                                                <td class="fw-bold fs-5">Total:</td>
                                                <td class="fw-bold fs-5">${{ number_format($order->order_total ?? 0, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Shipping activity</h5>

                        <div id="order-timeline">
                            @include('admin.orders.partials.timeline', ['order' => $order])
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card mb-3">
                    <div class="card-body">

                        <h5 class="card-title text-uppercase">Customer Details</h5>

                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/imgs/default.png') }}"
                                class="rounded-circle me-3" width="48">

                            <div>
                                <div class="fw-semibold">
                                    {{-- ✅ SIRF delivery_first_name aur delivery_last_name se name --}}
                                    @php
                                        $firstName = $order->delivery_first_name ?? '';
                                        $lastName = $order->delivery_last_name ?? '';
                                        $customerName = trim($firstName . ' ' . $lastName);
                                    @endphp
                                    {{ !empty($customerName) ? $customerName : 'Guest Customer' }}
                                </div>
                                <div class="text-muted small">
                                    Guest Customer
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase text-muted">Contact Info</h6>

                        <div class="small">
                            <div>
                                <span class="text-muted">Email:</span>
                                {{ $order->order_email ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="text-muted">Mobile:</span>
                                {{ $order->delivery_phone_no ?? 'N/A' }}
                            </div>
                        </div>

                    </div>
                </div>

                <x-address-card
                    title="Shipping Address"
                    :address="$order->shippingAddress"
                    :order="$order"
                />

                <x-address-card
                    title="Billing Address"
                    :address="$order->billingAddress"
                    :order="$order"
                />

                <div class="card mt-2">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Address Change History</h6>

                        @php
                            $auditLogs = $order->shippingAddress?->auditLogs ?? collect([]);
                        @endphp

                        @forelse($auditLogs as $log)
                            <div class="small border-bottom py-2">
                                <div>
                                    <strong>Updated by:</strong>
                                    {{ $log->user->name ?? 'System' }}
                                </div>

                                <div class="text-muted">
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                    ({{ $log->created_at->diffForHumans() }})
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No changes yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2">Payment Method</h6>

                        @php
                            $payment = payment_method_info($order->payment_method);
                        @endphp

                        <div class="d-flex align-items-center gap-2 mt-2">
                            <img src="{{ asset($payment['logo'] ?? '') }}"
                                alt="{{ $payment['name'] ?? 'N/A' }}"
                                height="22">

                            <span class="fw-semibold">
                                {{ $payment['name'] ?? ucfirst($order->payment_method) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>

    <div class="modal fade" id="editAddressModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Address</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="addressForm">
                        @csrf
                        <input type="hidden" id="address_id">

                        <input class="form-control mb-2" id="recipient" placeholder="Recipient">
                        <input class="form-control mb-2" id="street" placeholder="Street">
                        <input class="form-control mb-2" id="city" placeholder="City">
                        <input class="form-control mb-2" id="state" placeholder="State">
                        <input class="form-control mb-2" id="zip" placeholder="ZIP">
                        <input class="form-control mb-2" id="country" placeholder="Country">
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="saveAddress">Save</button>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function () {

            $(document).on('click', '.shipping-timeline li', function () {
                $(this).find('p').slideToggle(200);
            });

            $(document).on('click', '.changeStatus', function (e) {
                e.preventDefault();

                let orderId = $(this).data('id');
                let status  = $(this).data('status');

                $.ajax({
                    url: "{{ route('admin.order.changeStatus', ':id') }}".replace(':id', orderId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function (response) {

                        if (response.success) {

                            // Format text
                            let formattedStatus = status.replace('_', ' ');
                            formattedStatus = formattedStatus.charAt(0).toUpperCase() + formattedStatus.slice(1);

                            // Update badge
                            let badge = $('#show-status');

                            badge
                                .removeClass()
                                .addClass(
                                    'badge badge-' + response.badge.class +
                                    ' d-inline-flex align-items-center px-1 py-1 mr-2'
                                )
                                .css('height', '32px')
                                .html(
                                    '<i class="fas fa-' + response.badge.icon + ' mr-1"></i>' +
                                    formattedStatus
                                );

                            // Update timeline
                            $('#order-timeline').html(response.timeline);
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'Status update failed');
                    }
                });
            });

            $(document).on('click', '.edit-address', function () {
                let address = $(this).data('address');

                $('#address_id').val(address.id);
                $('#recipient').val(address.recipient);
                $('#street').val(address.street);
                $('#city').val(address.city);
                $('#state').val(address.state);
                $('#zip').val(address.zip);
                $('#country').val(address.country);

                $('#editAddressModal').modal('show');
            });

            $('#saveAddress').on('click', function () {

                let id = $('#address_id').val();
                let url = "{{ route('admin.address.update', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('input[name=_token]').val(),
                        recipient: $('#recipient').val(),
                        street: $('#street').val(),
                        city: $('#city').val(),
                        state: $('#state').val(),
                        zip: $('#zip').val(),
                        country: $('#country').val(),
                    },
                    success: function () {
                        location.reload();
                    }
                });
            });
        });
    </script>

    @if(in_array($order->order_status, ['delivered','canceled','returned']))
        <script>
            $('.changeStatus').addClass('disabled');
        </script>
    @endif
@endpush