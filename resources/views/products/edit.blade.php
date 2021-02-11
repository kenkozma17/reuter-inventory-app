@extends('layouts.app')
@section('content')
    <x-container>
        <form class="container" method="POST" action="{{route('products.update', $product->id)}}">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Product Name" name="name" value="{{$product->name}}" />
                </div>
                <div class="col-4">
                    <x-forms.input-number title="Product Quantity" name="quantity" value="{{$product->quantity}}" />
                </div>
                <div class="col-4">
                    <x-forms.input-text title="Product Price" name="price" value="{{$product->price}}" />
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Product Size" name="size" value="{{$product->size}}"/>
                </div>
                <div class="col-4">
                    <x-forms.input-text title="Product Color" name="color" value="{{$product->color}}" />
                </div>
                <div class="col-4">
                    <x-forms.input-number title="Notification Quantity" name="notification_quantity" value="{{$product->notification_quantity}}" />
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-forms.input-select title="Category" name="category" :items="['Appliances', 'Tools', 'Carpentry']" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            {{$product->has_notification ? 'checked="checked"' : ''}}
                            name="has_notification"
                            type="checkbox"
                            value="1">
                        <label class="form-check-label">
                            Notify Quantity
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </x-container>
@endsection