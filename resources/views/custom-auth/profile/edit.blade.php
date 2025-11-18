@extends('layouts.app')

@section('title', 'アカウント管理画面')

@section('content')

<div class="profile-container" x-data="{ tab: 'account' }">

    <!-- サイドバー -->
    <aside class="profile-sidebar">
        <button
            @click="tab = 'account'"
            :class="tab === 'account' ? 'active' : ''">
            アカウント設定
        </button>

        <button
            @click="tab = 'style'"
            :class="tab === 'style' ? 'active' : ''">
            スタイル設定
        </button>
    </aside>

    <!-- メインコンテンツ -->
    <main class="profile-main">

        <!-- アカウント設定 -->
        <div x-show="tab === 'account'">
            <div class="profile-section">
                @include('custom-auth.profile.partials.update-profile-information-form')
            </div>

            <div class="profile-section">
                @include('custom-auth.profile.partials.update-password-form')
            </div>

            <div class="profile-section">
                @include('custom-auth.profile.partials.delete-user-form')
            </div>
        </div>

        <!-- スタイル設定（準備中） -->
        <div x-show="tab === 'style'">
            <div class="profile-section">
                <h2>スタイル設定</h2>
                <p class="profile-info">この機能は現在準備中です。</p>
            </div>
        </div>

    </main>
</div>

@endsection