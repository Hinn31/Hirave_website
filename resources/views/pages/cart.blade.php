<head>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>
@extends('layouts.master')

@section('title', 'Your cart')

@section('content')

<h1>Your cart</h1>

<table class="cart-table">
  <thead>
    <tr>
      <th><input type="checkbox" id="select-all"></th>
      <th>Items</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total price</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="cart-items">
    <!-- Danh sách sản phẩm sẽ được load ở đây -->
  </tbody>
</table>

<div class="cart-footer">
  Total payment: <span class="total-amount" id="total-payment">0</span> VND
  <button class="btn-continue" onclick="window.location.href='/'">Continue shopping</button>
  <button class="btn-checkout" onclick="alert('Chưa có chức năng thanh toán')">Checkout</button>
</div>

<script>
    window.apiCartUrl   = "{{ url('/api/cart') }}";
    window.apiUpdateUrl = "{{ url('/api/cart/update') }}";
    window.apiRemoveUrl = "{{ url('/api/cart/remove') }}";
    window.token        = localStorage.getItem('token');
</script>

<script src="{{ asset('js/cart1.js') }}"></script>

@endsection
