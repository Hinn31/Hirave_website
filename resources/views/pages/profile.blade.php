<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
@extends('layouts.master')

@section('title', 'Profile')

@section('content')

    <div class="profile">
        <div class="profile__avatar">
            <img src="https://cdn2.fptshop.com.vn/unsafe/Uploads/images/tin-tuc/176879/Originals/anh-rose%20(2).jpg" alt="Avatar">
            <label class="edit-icon">✎</label>
        </div>
        <p class="profile__name" id="displayName">{{$user->fullname}} <span>({{$user->username}})</span></p>

        <form class="profile__form" id="updateProfileForm" data-user-id="{{ $user->id }}">
            <label for="username">Username</label>
            <input type="text" id="username" value="{{$user->username}}" />

            <label for="fullname">Full name</label>
            <input type="text" id="fullname" value="{{$user->fullname}}" />

            <label for="email">Email</label>
            <input type="email" id="email" value="{{$user->email}}" />

            <button type="submit">Save</button>
        </form>
    </div>
    <script src="{{ asset('js/profile.js')}}"></script>
@endsection
