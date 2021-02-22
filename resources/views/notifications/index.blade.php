@php
use Carbon\Carbon;
$carbon = new Carbon();
@endphp
@extends('layouts.app')
@section('content')
    <x-container>
        <div class="list-group">
            @if(count(auth()->user()->unreadNotifications))
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 font-weight-bold">{{ $notification->data['product']['name'] }}</h5>
                            <small>{{$carbon->parse($notification->created_at)->diffForHumans()}}</small>
                        </div>
                        <p class="mb-1 font-weight-bold">Current Quantity: {{ $notification->data['product']['quantity'] }}</p>
                        <p class="mb-1 font-weight-bold">Low Quantity: {{ $notification->data['product']['notification_quantity'] }}</p>
                        <p class="mb-1">
                            {{ $notification->data['details'] }}
                        </p>
                        <a class="text-white btn btn-primary mr-2" href="/admin/transactions/create/{{$notification->data['product']['id']}}">
                            Increase Quantity
                        </a>
{{--                        <a class="text-white btn btn-info mr-2" href="">Mark as Read</a>--}}
{{--                        <a class="text-white btn btn-danger mr-2" href="">Delete</a>--}}
                    </div>
                @endforeach
            @else
                <p>No Notifications!</p>
            @endif
        </div>
    </x-container>
@endsection
