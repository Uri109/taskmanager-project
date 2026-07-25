<div class="form-grid">
@include('partials.input', ['name'=>'title','label'=>'Project title','placeholder'=>'e.g. Summer product launch','value'=>$project->title ?? ''])
<label class="field full-span"><span>Description <b>Optional</b></span><textarea name="description" placeholder="What does success look like for this project?">{{ old('description', $project->description ?? '') }}</textarea>@error('description')<small>{{ $message }}</small>@enderror</label>
@include('partials.input', ['name'=>'due_date','label'=>'Target date','type'=>'date','value'=>isset($project) && $project->due_date ? $project->due_date->format('Y-m-d') : ''])
<label class="field"><span>Accent color</span><div class="color-row"><input type="color" name="color" value="{{ old('color', $project->color ?? '#7c5cff') }}"><span>Choose your project mood</span></div>@error('color')<small>{{ $message }}</small>@enderror</label>
</div>
