@extends('layouts.app')
@section('content')
{{--    {{dd($products)}}--}}
<v-app>
    <products-datatable :data='{{$products}}' />
</v-app>
@endsection
