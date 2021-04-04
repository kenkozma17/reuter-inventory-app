@props(['title', 'name', 'items', 'required' => 'false', 'value' => ''])
<div class="form-group">
    <label>{{$title}}</label>
    <select class="form-control border-black {{$errors->has($name) ? 'border-red-500' : ''}}" name="{{$name}}">
        <option {{ $value ? '' : 'selected'}} value="">Select {{$title}}</option>
        @foreach($items as $index => $item)
            <option {{$index === $value ? 'selected' : ''}} value="{{$index}}">{{$item}}</option>
        @endforeach
    </select>
    @if ($errors->has($name))
        <span class="text-danger">{{ $errors->first($name) }}</span>
    @endif
</div>