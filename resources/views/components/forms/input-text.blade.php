@props(['title', 'smallText' => '', 'name'])
<div class="form-group">
    <label>{{$title}}</label>
    <input type="text" class="form-control" name="{{$name}}" placeholder="Enter {{$title}}">
    @if($smallText)
        <small class="form-text text-muted">{{$smallText}}</small>
    @endif
</div>