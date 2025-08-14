@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<div class="profile-container">
    <div class="profile-header">
        <h1>Welcome, {{ $user->fullname ?? $user->username }}</h1>
    </div>

    <form id="updateProfileForm" data-user-id="{{ $user->id }}" enctype="multipart/form-data">
        <div class="profile-card">
            <div class="profile-top-bar"></div>

            <div class="profile-info">
                <div class="profile-avatar">
                  <img id="avatarPreview"
                    src="{{ asset($user->avatar ?? 'images/avatars/default.jpg') }}?t={{ time() }}"
                     alt="Avatar">
                    <label for="avatarInput" class="avatar-edit-btn" title="Change avatar">✎</label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;">
                </div>

                <div class="profile-basic">
                    <h2 id="displayName">{{ $user->fullname }} <span>({{ $user->username }})</span></h2>
                    <p>{{ $user->email }}</p>
                </div>
            </div>

            <div class="profile-form">
                <div class="form-row">
                    <label for="fullname">Full Name</label>
                    <input id="fullname" name="fullname" type="text" value="{{ $user->fullname }}" placeholder="Your Full Name" required>
                </div>
                <div class="form-row">
                    <label for="username">Nick Name</label>
                    <input id="username" name="username" type="text" value="{{ $user->username }}" placeholder="Your Nick Name" required>
                </div>
                <div class="form-row">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}" placeholder="Your Email" required>
                </div>
                <div class="form-row">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ $user->phone ?? '' }}" placeholder="Your Phone">
                </div>
            </div>

            <div class="profile-footer">
                <button type="submit" class="btn-update">Update</button>
                <button id="btnLogout" type="button" class="btn-logout">Log out</button>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/profile.js') }}"></script>
@endsection
