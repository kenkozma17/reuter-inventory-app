@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach($products as $product)
            <li>{{$product->name}}</li>
        @endforeach
    </div>
@endsection
