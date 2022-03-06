@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Stream {{$item->stream_id}} Song List - edit</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/stream/song_list/{{$item->stream_id}}">back</a>
                        <hr>
                        <form method="POST" action="/admin/stream/song_list/update/{{$item->id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="played_at">Game</label>
                                <div class="col-10">
                                    <select class="form-control" id="played_at" name="played_at">
                                        @foreach($games as $game)
                                            <option @if($game->game == $item->played_at) selected @endif
                                             value="{{$game->game}}">game {{$game->game}}
                                            </option>
                                        @endforeach
                                      </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-2 col-form-label">Youtube Video ID</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="link" name="link" required value="{{$item->link}}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="link" class="col-2 col-form-label">example:</label>
                                <div class="col-10">
                                    <img src="/images/youtube_video_example.jpg" alt="">
                                </div>
                            </div>
                            <hr>

                            <button type="submit" class="btn btn-primary d-block mx-auto">update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @if(Session::has('update'))
        <script>
            alert('update success!')
        </script>
    @endif
@endsection
