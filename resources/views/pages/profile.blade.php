<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Welcome, {{ $user->fullname ?? $user->username }}</h1>
        <button class="btn-edit">Edit</button>
    </div>

    <div class="profile-card">
        <div class="profile-top-bar"></div>

        <div class="profile-info">
            <div class="profile-avatar">
            <img id="avatarPreview" src="{{ asset($user->avatar ?? 'images/avatars/default.jpg') }}" alt="Avatar">
            <label for="avatarInput" class="avatar-edit-btn" title="Thay ảnh">✎</label>
            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;">
            </div>
            <div class="profile-basic">
                <h2>{{ $user->fullname }}</h2>
                <p>{{ $user->email }}</p>
            </div>
        </div>

        <div class="profile-form">
            <div class="form-row">
                <label>Full Name</label>
                <input type="text" value="{{ $user->fullname }}" placeholder="Your First Name">
            </div>
            <div class="form-row">
                <label>Nick Name</label>
                <input type="text" value="{{ $user->username }}" placeholder="Your Nick Name">
            </div>
            <div class="form-row">
                <label>Phone</label>
                <select>
                    <option value="">{{ $user->phone ?? 'Your Phone' }}</option>
                </select>
            </div>
            <div class="form-row">
                <label>Date of Birth</label>
                <input type="date" value="{{ $user->dob ?? '' }}">
            </div>
        </div>

        <div class="profile-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/profile.js') }}"></script>

@endsection
