@extends('layouts.admin')

@section('title', 'Message management')

@section('content')
    <h3>Message management</h3>

    <form action="{{ route('messages.index') }}" method="GET" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Search Product">
        <button class="btn btn-dark">Search</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone number</th>
                <th>Email</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $msg)
                <tr>
                    <td>{{ $msg->id }}</td>
                    <td>{{ $msg->first_name }}</td>
                    <td>{{ $msg->last_name }}</td>
                    <td>{{ $msg->phone }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ $msg->message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
