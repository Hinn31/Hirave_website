 @extends('layouts.admin')
@section('title', 'Product Management')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<div class="user-management">
  <h3>User Management</h3>

  <!-- Search bar -->
  <div class="top-bar">
    <input type="text" id="keyword" placeholder="Search User" />
    <button class="btn-search" onclick="searchUser()">Search</button>
  </div>

  <!-- Table -->
  <table class="user-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Day of Birth</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="users-tbody">
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->fullname}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->date_of_birth}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td class="actions">
                    <a href="{{ route('users.edit', $user->id) }}">
                        <button class="edit">Edit</button>
                    </a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </tbody>
  </table>

  <!-- Pagination -->
  <div class="pagination">
    {{ $users->links() }}
  </div>
</div>
<script src="{{ asset('js/search.js') }}"></script>
@endsection
