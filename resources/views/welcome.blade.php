@extends('layouts.app')
@section('title', 'Make progress visible')
@section('content')
<section class="hero shell">
    <div class="hero-copy reveal">
        <span class="eyebrow"><i></i> Thoughtful work, beautifully organized</span>
        <h1>Your team’s next<br><em>big thing</em> starts here.</h1>
        <p>Orbit turns scattered to-dos into focused momentum. Plan projects, move work forward, and celebrate every win.</p>
        <div class="hero-actions"><a class="btn" href="{{ route('register') }}">Build your first project <span>→</span></a><a class="play-link" href="{{ route('login') }}"><b>↗</b> I have an account</a></div>
        <div class="social-proof"><div class="mini-avatars"><i>J</i><i>M</i><i>A</i></div><span><strong>Simple by design</strong><br>Ready in under a minute</span></div>
    </div>
    <div class="hero-visual reveal delay-1">
        <div class="orb orb-one"></div><div class="orb orb-two"></div>
        <div class="demo-window">
            <div class="demo-top"><span class="brand-mark tiny">O</span><span></span><i></i></div>
            <div class="demo-body"><aside><b></b><b></b><b></b></aside><div class="demo-content"><small>PRODUCT LAUNCH</small><h3>Bring ideas to orbit.</h3><div class="demo-stats"><span>12<br><small>Tasks</small></span><span>67%<br><small>Progress</small></span></div><div class="demo-task"><i>✓</i><span>Finalize brand direction<small>Completed today</small></span></div><div class="demo-task"><i></i><span>Publish launch page<small>High priority</small></span></div></div></div>
        </div>
        <div class="floating-note">✦ <span><strong>Flow state</strong><small>Everything in its place</small></span></div>
    </div>
</section>
@endsection
