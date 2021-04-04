@extends('layouts.app')
@section('content')
    <x-container>
        <form class="container" method="POST" action="{{route('categories.store')}}">
            @csrf
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Category Name" name="name" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </x-container>
@endsection