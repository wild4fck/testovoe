@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <notifications group="message"/>
        </notifications>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <main-app></main-app>
            </div>
        </div>
    </div>
@endsection
