@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="text-center heading mt-3">Profile</h1>
        <p class="text-center">Fill in the fields for getting access to the all site functions</p>
        <profile user="{{$user}}"></profile>
    </div>

@endsection