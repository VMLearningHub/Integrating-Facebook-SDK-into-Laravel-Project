@extends('layouts.app')

@section('content')
    <div class="px-3 text-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Post</h4>
                        </div>
                        <div class="card-body">
                            <a href="{{route('post.index')}}" class="btn btn-lg btn-block btn-outline-primary">Click</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Profile</h4>
                        </div>
                        <div class="card-body">
                            <a href="{{route('profile.index')}}" class="btn btn-lg btn-block btn-outline-primary">Click</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
