@props(['title', 'name', 'items'])
<div class="form-group">
    <label>{{$title}}</label>
    <select class="form-control border-black" aria-label="Default select example" name="{{$name}}">
        <option selected>Select {{$title}}</option>
        @foreach($items as $item)
            <option value="{{$item}}">{{$item}}</option>
        @endforeach
    </select>
</div>