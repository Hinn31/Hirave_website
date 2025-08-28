@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<link rel="stylesheet" href="{{ asset('css/order_management.css') }}">

<h3 class="mb-4">Quản lý đơn hàng</h3>

<form action="{{ route('orders.index') }}" method="GET" class="d-flex mb-4">
    <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm sản phẩm">
    <button class="btn btn-dark">Tìm kiếm</button>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Mã khách hàng</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Tổng cộng</th>
                <th>Ngày</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total }} $</td>
                    <td>
                        {{ $order->date ? \Carbon\Carbon::parse($order->date)->format('Y-m-d') : 'N/A' }}
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                        <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Không tìm thấy đơn hàng.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Thêm phân trang -->
{{ $orders->links() }}
@endsection