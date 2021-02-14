@extends('layouts.app')
@section('content')
    <x-container>
        <form class="container" method="POST" action="{{route('transactions.store', $product->id)}}">
            @csrf
            <div class="mb-3">
                <h2 class="h2">Product: <span class="font-bold">{{$product->name}}</span></h2>
                <h3 class="h3">Quantity: <span class="font-bold">{{$product->quantity}}</span></h3>
                <hr class="mt-3">
            </div>
            <div class="row">
                <div class="col-4">
                    <x-forms.input-text title="Customer Name" name="customer_name" />
                </div>
                <div class="col-4">
                    <x-forms.input-number title="Quantity" name="quantity" />
                </div>
                <div class="col-4">
                    <x-forms.input-text title="Transaction #" name="transaction_number" />
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <x-forms.input-textarea title="Comments/Notes" name="comments" />
                </div>
                <div class="col-6">
                    <x-forms.input-select
                        title="Transaction Type"
                        name="type"
                        :items="['withdrawal' => 'Withdrawal', 'increase' => 'Increase', 'decrease' => 'Decrease']" />
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Create Transaction</button>
                </div>
            </div>
        </form>
    </x-container>
@endsection