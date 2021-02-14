@extends('layouts.app')
@section('content')
    <v-app>
        <transaction-datatable :data='{{$transactions}}' ></transaction-datatable>
    </v-app>
@endsection