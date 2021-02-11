@props(['title', 'name', 'items'])
<div class="form-group">
    <label>{{$title}}</label>
    <select class="form-control border-black" aria-label="Default select example" name="{{$name}}">
        <option selected>Select {{$title}}</option>
        @foreach($items as $index => $item)
            <option value="{{$index}}">{{$item}}</option>
        @endforeach
    </select>
</div>