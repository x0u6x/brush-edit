@extends('layouts.app')

@section('title', '管理画面')

@section('content')

<div class="profile-wrapper">
    <h1 class="profile-title">プロフィール設定</h1>

    <!-- プロフィール情報更新 -->
    <section class="profile-section">
        <h2>基本情報</h2>
        @include('auth.profile.partials.update-profile-information-form')
    </section>

    <!-- パスワード更新 -->
    <section class="profile-section">
        <h2>パスワード変更</h2>
        @include('auth.profile.partials.update-password-form')
    </section>

    <!-- アカウント削除 -->
    <section class="profile-section delete-section">
        <h2>アカウント削除</h2>
        @include('auth.profile.partials.delete-user-form')
    </section>
</div>