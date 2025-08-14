@extends('layouts.master')

@section('title', 'Order Tracking')

@section('content')
<link rel="stylesheet" href="{{ asset('css/order_management.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mt-4">
    {{-- Thanh trạng thái --}}
    <ul id="statusTabs" class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link active" href="#" data-status="All">All (<span id="countAll">0</span>)</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-status="Waiting">Waiting (<span id="countWaiting">0</span>)</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-status="Progress">Progress (<span id="countProgress">0</span>)</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-status="Transport">Transport (<span id="countTransport">0</span>)</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-status="Complete">Complete (<span id="countComplete">0</span>)</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-status="Canceled">Canceled (<span id="countCanceled">0</span>)</a></li>
    </ul>

    {{-- Danh sách đơn hàng --}}
    <div id="orderList" class="row"></div>
    <div id="errorMsg" class="text-danger mt-3"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let allOrders = {};
    const errorMsg = document.getElementById('errorMsg');

    async function loadUser() {
        try {
            const response = await fetch('/api/user', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });

            if (response.status === 401) {
                errorMsg.textContent = 'You are not authorized. Please log in.';
                return null;
            }

            const data = await response.json();
            return data;
        } catch (err) {
            console.error(err);
            errorMsg.textContent = 'Failed to load user info.';
            return null;
        }
    }

    async function loadOrders() {
        errorMsg.textContent = '';
        try {
            const response = await fetch('/api/orders', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });

            if (response.status === 401) {
                errorMsg.textContent = 'You are not authorized. Please log in.';
                return;
            }

            const data = await response.json();

            if (!data || !data.orders || !data.orderCounts) {
                errorMsg.textContent = 'Invalid response from server.';
                console.error('Invalid response:', data);
                return;
            }

            allOrders = data.orders;

            // Cập nhật số đếm
            document.getElementById('countAll').textContent = data.orderCounts.All || 0;
            document.getElementById('countWaiting').textContent = data.orderCounts.Waiting || 0;
            document.getElementById('countProgress').textContent = data.orderCounts.Progress || 0;
            document.getElementById('countTransport').textContent = data.orderCounts.Transport || 0;
            document.getElementById('countComplete').textContent = data.orderCounts.Complete || 0;
            document.getElementById('countCanceled').textContent = data.orderCounts.Canceled || 0;

            renderOrders('All');

        } catch (err) {
            console.error(err);
            errorMsg.textContent = 'Server error. Please try again later.';
        }
    }

    function renderOrders(status) {
        const container = document.getElementById('orderList');
        container.innerHTML = '';

        const filteredOrders = status === 'All'
            ? Object.values(allOrders).flat()
            : allOrders[status] || [];

        if (filteredOrders.length === 0) {
            container.innerHTML = '<div class="col-12"><p>No orders found.</p></div>';
            return;
        }

        filteredOrders.forEach(order => {
            if (!order.order_details) return;
            order.order_details.forEach(detail => {
                const product = detail.product || {};
                container.innerHTML += `
                    <div class="col-12 order-card">
                        <img src="${product.image_url || '/images/default.png'}">
                        <div class="product-info">
                            <h5>${product.name || 'Unnamed Product'}</h5>
                            <p>${product.category || ''}</p>
                            <p>Quantity: ${detail.quantity || 0}</p>
                        </div>
                        <div class="order-price">
                            <p class="price">${Number(detail.price || 0).toLocaleString()}$</p>
                            ${order.status === 'pending' ? `<button class="cancel-btn">Cancel order</button>` : ''}
                        </div>
                    </div>
                `;
            });
        });
    }

    document.getElementById('statusTabs').addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            document.querySelectorAll('#statusTabs .nav-link').forEach(a => a.classList.remove('active'));
            e.target.classList.add('active');
            renderOrders(e.target.dataset.status);
        }
    });

    // Load user info và orders
    loadUser().then(user => {
        if (user) {
            loadOrders();
        }
    });
});

</script>
@endsection
