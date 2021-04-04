@extends('layouts.app')
@section('content')
    <x-container>
        <form class="container" method="POST" action="{{route('categories.update', $category->id)}}">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Category Name" name="name" value="{{$category->name}}" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </x-container>
@endsection