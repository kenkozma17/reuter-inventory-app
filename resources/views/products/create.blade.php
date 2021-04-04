@extends('layouts.app')
@section('content')
    <x-container>
        <form class="container" method="POST" action="{{route('products.store')}}">
            @csrf
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Product Name" name="name" />
                </div>
                <div class="col-4">
                    <x-forms.input-number title="Product Quantity" name="quantity" />
                </div>
                <div class="col-4">
                    <x-forms.input-text title="Product Price (PHP)" name="price" />
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Product Size" name="size" />
                </div>
                <div class="col-4">
                    <x-forms.input-text title="Product Color" name="color" />
                </div>
                <div class="col-4">
                    <x-forms.input-number title="Notification Quantity" name="notification_quantity" />
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-forms.input-select title="Category" name="category" :items="$categories" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" name="has_notification" type="checkbox" value="1">
                        <label class="form-check-label">
                            Notify Quantity
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </x-container>
@endsection