@extends('layouts.app')

@section('title', 'アカウント管理画面')

@section('content')

<div class="profile-container" x-data="{ tab: 'profile' }">

    <!-- サイドバー -->
    <aside class="profile-sidebar">
        <button @click="tab = 'profile'"
            :class="tab === 'profile' ? 'active' : ''">
            基本情報
        </button>

        <button @click="tab = 'password'"
            :class="tab === 'password' ? 'active' : ''">
            パスワード変更
        </button>

        <button @click="tab = 'delete'"
            :class="tab === 'delete' ? 'active delete-btn' : ''">
            アカウント削除
        </button>
    </aside>

    <!-- メインコンテンツ -->
    <main class="profile-main">

        <div x-show="tab === 'profile'">
            @include('custom-auth.profile.partials.update-profile-information-form')
        </div>

        <div x-show="tab === 'password'">
            @include('custom-auth.profile.partials.update-password-form')
        </div>

        <div x-show="tab === 'delete'">
            @include('custom-auth.profile.partials.delete-user-form')
        </div>

    </main>

</div>

@endsection