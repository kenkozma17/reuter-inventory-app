@extends('layouts.app')
@section('content')
<v-app>
    <products-datatable :data='{{$products}}' />
</v-app>
@endsection
