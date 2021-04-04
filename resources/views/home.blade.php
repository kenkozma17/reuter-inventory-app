@extends('layouts.app')
@section('content')
    <div class="container">
        <v-app>
            <products-datatable :data="{{$products}}" />
        </v-app>
    </div>
@endsection
