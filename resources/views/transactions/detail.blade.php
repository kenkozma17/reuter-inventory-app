@extends('layouts.app')
@section('content')
    <x-container>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3 class="mb-3">
                    <span
                        class="text-white badge text-base rounded-pill
                            {{$transaction->type === 'increase' ? 'bg-success' : 'bg-danger'}}">
                        {{ \Illuminate\Support\Str::ucfirst($transaction->type) }}
                    </span>
                    </h3>
                    <h4 class="h4 font-weight-bold">{{$transaction->product->name}}</h4>
                    <h4 class="h4">Quantity (Increased/Decreased): <span class="font-weight-bold">{{$transaction->quantity}}</span></h4>
                    <h4 class="h4">Previous Quantity: <span class="font-weight-bold">{{$transaction->previous_quantity}}</span></h4>
                    <h4 class="h4">New Quantity: <span class="font-weight-bold">{{$transaction->new_quantity}}</span></h4>
                </div>
                <div class="col-6 text-right">
                    @if($transaction->transaction_number)
                        <h4 class="h4">Transaction #: {{$transaction->transaction_number}}</h4>
                    @endif
                    @if($transaction->customer_name)
                        <h5 class="h5">Customer: <span class="font-weight-bold">{{$transaction->customer_name}}</span></h5>
                    @endif
                    <p>{{$transaction->date}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="h5">Comments:</h5>
                    <p>{{$transaction->comments}}</p>
                </div>
            </div>
        </div>
    </x-container>
@endsection