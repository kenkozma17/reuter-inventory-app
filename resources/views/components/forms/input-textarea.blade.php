@props(['title', 'smallText' => '', 'name', 'value' => ''])
<div class="form-group">
    <label>{{$title}}</label>
    <textarea type="text"
           class="form-control {{$errors->has($name) ? 'border-red-500' : ''}}"
           name="{{$name}}"
           placeholder="Enter {{$title}}">{{ $value ? $value : old($name) }}</textarea>
    @if($smallText)
        <small class="form-text text-muted">{{$smallText}}</small>
    @endif
    @if ($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>