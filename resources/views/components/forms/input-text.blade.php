@props(['title', 'smallText' => '', 'name', 'value' => ''])
<div class="form-group">
    <label>{{$title}}</label>
    <input type="text"
           class="form-control {{$errors->has($name) ? 'border-red-500' : ''}}"
           name="{{$name}}"
           placeholder="Enter {{$title}}"
           value="{{ $value ? $value : old($name) }}">
    @if($smallText)
        <small class="form-text text-muted">{{$smallText}}</small>
    @endif
    @if ($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>