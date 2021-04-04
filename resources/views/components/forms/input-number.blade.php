@props(['disabled' => false, 'title', 'smallText' => '', 'name', 'value' => ''])
<div class="form-group">
    <label>{{$title}}</label>
    <input type="number"
           class="form-control {{$errors->has($name) ? 'border-red-500' : ''}}"
           name="{{$name}}"
           {{$disabled ? 'disabled="disabled"' : ''}}
           value="{{ $value ? $value : old($name) }}"
           placeholder="Enter {{$title}}">
    @if($smallText)
        <small class="form-text text-muted">{{$smallText}}</small>
    @endif
    @if ($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>