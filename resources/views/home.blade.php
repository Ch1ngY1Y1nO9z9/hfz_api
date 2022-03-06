@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome! {{Auth::user()->name}}!!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <img width="100%" src="https://pbs.twimg.com/media/EYJWg9lUMAA7LfL.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
