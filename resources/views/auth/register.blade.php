@extends('layouts.app')
@section('title', 'Create your workspace')
@section('content')
<section class="auth-wrap shell"><div class="auth-copy"><span class="eyebrow"><i></i> Your fresh start</span><h1>Make room for<br><em>meaningful work.</em></h1><p>A calmer, clearer way to move ideas from maybe to done.</p></div><div class="form-card reveal">
<h2>Create your account</h2><p>Your workspace is only a moment away.</p>
<form method="POST" action="{{ route('register') }}" class="stack">@csrf
@include('partials.input', ['name'=>'name','label'=>'Your name','type'=>'text','placeholder'=>'Ada Lovelace'])
@include('partials.input', ['name'=>'email','label'=>'Email address','type'=>'email','placeholder'=>'you@example.com'])
@include('partials.input', ['name'=>'password','label'=>'Password','type'=>'password','placeholder'=>'At least 8 characters'])
@include('partials.input', ['name'=>'password_confirmation','label'=>'Confirm password','type'=>'password','placeholder'=>'Repeat your password'])
<button class="btn full">Create my workspace <span>→</span></button></form><p class="form-foot">Already have an account? <a href="{{ route('login') }}">Sign in</a></p></div></section>
@endsection
