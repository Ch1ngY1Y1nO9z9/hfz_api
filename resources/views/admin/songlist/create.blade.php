@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Stream {{$stream_number}} Song List - create</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/stream/song_list/{{$stream_number}}">back</a>
                        <hr>
                        <form method="POST" action="/admin/stream/song_list/store" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="stream_id" value="{{$stream_number}}">

                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="played_at">Game</label>
                                <div class="col-10">
                                    <select class="form-control" id="played_at" name="played_at">
                                        @foreach($games as $game)
                                            <option value="{{$game->game}}">game {{$game->game}}: {{$game->rule}} - {{$game->participants}}</option>
                                        @endforeach
                                      </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-2 col-form-label">Youtube Video ID</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="link" name="link" required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="link" class="col-2 col-form-label">example:</label>
                                <div class="col-10">
                                    <img src="/images/youtube_video_example.jpg" alt="">
                                </div>
                            </div>

                            <hr>
                            <button type="submit" class="btn btn-primary d-block mx-auto">Store</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @if(Session::has('store'))
        <script>
            alert('store success!')
        </script>
    @endif
@endsection
