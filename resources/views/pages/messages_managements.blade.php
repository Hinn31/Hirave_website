@extends('layouts.admin')

@section('title', 'Message management')

@section('content')
<link rel="stylesheet" href="{{ asset('css/messages_management.css') }}">

<h3 class="mb-4">Message Management</h3>

<form action="{{ route('messages.index') }}" method="GET" class="d-flex mb-4">
    <input type="text" name="search" class="form-control me-2" placeholder="Search messages...">
    <button class="btn btn-dark">Search</button>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone number</th>
                <th>Email</th>
                <th>Message</th>
                <th>Sent At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
                <tr>
                    <td>{{ $msg->id }}</td>
                    <td>{{ $msg->first_name }}</td>
                    <td>{{ $msg->last_name }}</td>
                    <td>{{ $msg->phone_number }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ $msg->message }}</td>
                    <td>
                        {{ $msg->created_at ? \Carbon\Carbon::parse($msg->created_at)->format('d/m/Y H:i') : 'N/A' }}
                    </td>
                    <td>
                        <form action="{{ route('messages.destroy', $msg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No messages found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
