@extends('layouts.app')
@section('content')
<v-app>
    <categories-datatable :data='{{$categories}}' />
</v-app>
@endsection
