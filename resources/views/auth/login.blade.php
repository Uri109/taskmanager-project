@extends('layouts.app')
@section('title', 'Welcome back')
@section('content')
<section class="auth-wrap shell"><div class="auth-copy"><span class="eyebrow"><i></i> Welcome back</span><h1>Pick up where<br>you <em>left off.</em></h1><p>Your projects, tasks, and progress are waiting for you.</p></div><div class="form-card reveal">
<h2>Sign in to Orbit</h2><p>Enter your details to continue.</p>
<form method="POST" action="{{ route('login') }}" class="stack">@csrf
@include('partials.input', ['name'=>'email','label'=>'Email address','type'=>'email','placeholder'=>'you@example.com'])
@include('partials.input', ['name'=>'password','label'=>'Password','type'=>'password','placeholder'=>'Your password'])
<label class="check"><input type="checkbox" name="remember"> Keep me signed in</label>
<button class="btn full">Sign in <span>→</span></button></form><p class="form-foot">New to Orbit? <a href="{{ route('register') }}">Create an account</a></p></div></section>
@endsection
