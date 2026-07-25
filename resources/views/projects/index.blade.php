@extends('layouts.app')
@section('title', 'Your projects')
@section('content')
<section class="page shell">
<div class="page-head reveal"><div><span class="eyebrow"><i></i> Your workspace</span><h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}.</h1><p>Here’s what’s moving forward today.</p></div><a class="btn" href="{{ route('projects.create') }}"><b>＋</b> New project</a></div>
@if($projects->isEmpty())
<div class="empty reveal"><span>✦</span><h2>Space for your next big thing.</h2><p>Create a project, break it into tasks, and watch the momentum build.</p><a class="btn" href="{{ route('projects.create') }}">Create your first project →</a></div>
@else
<div class="project-grid">
@foreach($projects as $project)
@php($progress = $project->tasks_count ? round(($project->completed_tasks_count / $project->tasks_count) * 100) : 0)
<a href="{{ route('projects.show', $project) }}" class="project-card reveal" style="--accent:{{ $project->color }}">
<div class="project-card-top"><span class="project-icon">{{ strtoupper(substr($project->title,0,1)) }}</span><span class="arrow">↗</span></div>
<h2>{{ $project->title }}</h2><p>{{ Str::limit($project->description ?: 'A fresh canvas ready for the work ahead.', 100) }}</p>
<div class="progress-meta"><span>{{ $project->completed_tasks_count }} of {{ $project->tasks_count }} tasks</span><strong>{{ $progress }}%</strong></div><div class="progress"><i style="width:{{ $progress }}%"></i></div>
<footer><span>{{ $project->due_date ? 'Due '.$project->due_date->format('M j') : 'No deadline' }}</span><span>{{ $project->updated_at->diffForHumans() }}</span></footer></a>
@endforeach
<a href="{{ route('projects.create') }}" class="project-card add-card"><span>＋</span><h3>Start something new</h3><p>Turn your next idea into action.</p></a>
</div>@endif</section>
@endsection
