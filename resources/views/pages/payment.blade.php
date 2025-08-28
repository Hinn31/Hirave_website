@extends('layouts.master')
@section('title', 'Payment')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@section('content')
<div class="payment">
    <form id="paymentForm" class="payment__form" onsubmit="event.preventDefault(); submitPayment();">
        @csrf

        <div class="payment__form-section">
            @include('components.payment-form') 
        </div>

        <div class="payment__summary">
            <div id="order-summary" class="payment__order-summary">
            </div>
                @include('components.order-summary')
            <div class="payment__submit">
                <button id="btn-submit" type="submit" class="payment__submit-btn">Payment</button>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/payment.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', loadPaymentPage);
</script>
@endsection

