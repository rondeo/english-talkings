@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>

@endsection
@section('content')
    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container">
                <h1 class="mb-0">Skype talkings</h1>
                <h3 class="mb-0">The place where you can talk free</h3>
            </div>
        </div>
        <div class="bg-circle-1 bg-circle"></div>
        <div class="bg-circle-2 bg-circle"></div>
        <div class="bg-circle-3 bg-circle"></div>
        <div class="bg-circle-4 bg-circle"></div>
    </header>
    <div class="container mt-5">
        <h2 class="text-center">Find new friends</h2>
        <p class="text-center">Find people all over the world are ready for skype conversation, meet friends and practice in new language.</p>

        <img style="border: 5px solid #f0f0f0; max-width: 800px;"
             class="img img-responsive mx-auto d-block"
             src="png/table-screenshot.png"
             alt="">
    </div>
    <section class="container-fluid mt-5 pr-0 pl-0">
        <h2 class="text-center">Our geography</h2>
        <p class="text-center">Looking</p>
        <world-map green-data="{{$greenData}}" red-data="{{$redData}}" yellow-data="{{$yellowData}}"></world-map>
    </section>
@endsection
@section('footer')
    <section id="footer" class="bg-red pt-3">
        <div class="container">
            <div class="row text-center text-xs-center text-sm-left text-md-left">
                <div class="col-xs-12 offset-md-4 offset-md-4 col-sm-3 col-md-3">
                    <ul class="list-unstyled quick-links">
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3">
                    <ul class="list-unstyled quick-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Advertising</a></li>
                    </ul>
                </div>
            </div>
            {{--<div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
                    <ul class="list-unstyled list-inline social text-center">
                        <li class="list-inline-item"><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href=""><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href=""><i class="fa fa-google-plus"></i></a></li>
                        <li class="list-inline-item"><a href="" target="_blank"><i class="fa fa-envelope"></i></a></li>
                    </ul>
                </div>
                </hr>
            </div>--}}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                    <p class="h6">&copy All right Reversed.</p>
                    <p>Made by <a href="https://www.facebook.com/sergey.samoylenko.376">Partizan_LERO</a></p>
                </div>
                </hr>
            </div>
        </div>
    </section>
@endsection