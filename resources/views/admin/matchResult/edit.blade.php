@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Stream {{$stream_id}} Match results - edit</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/stream/match_result/{{$stream_id}}">back</a>
                        <hr>
                        <form method="POST" action="/admin/stream/match_result/update/{{$item->id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="game" class="col-2 col-form-label">Game</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="game" name="game" value="{{$item->game}}" min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="type">Type</label>
                                <div class="col-10">
                                    <select class="form-control" id="type" name="type">
                                        <option @if($item->type == '1v1') selected @endif value="1v1">1v1</option>
                                        <option @if($item->type == '2v2') selected @endif value="2v2">2v2</option>
                                        <option @if($item->type == 'MULTi') selected @endif value="MULTi">MULTi</option>
                                      </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rule" class="col-2 col-form-label">Context</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="rule" name="rule" value="{{$item->rule}}">
                                    <div class="col-12">
                                        <small class="text-danger">
                                            example: 1Fall, Extreme Rules, Falls Count Anywhere, Tag-Team, Backstage, Championship Match, Tag-Team Championship, Fatal 4-Way Elimination, Triple Threat Elimination, Royal Rumble...
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="participants" class="col-2 col-form-label">Participants</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="participants" name="participants" value="{{$item->participants}}">
                                    <div class="col-12">
                                        <small class="text-danger">
                                            1v1 format example: Yagoo, Miko<br>
                                            2v2 format example: Sora, A-chan / Suisei, AZKi
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="result" class="col-2 col-form-label">Result</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="result" name="result" value="{{$item->result}}">
                                    <div class="col-12">
                                        <small class="text-danger">
                                            put Winner's short name from down below or Draw
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 text-danger">
                                    *Please copy the short name down below, onegai...
                                </div>
                                <div class="col-12">
                                    <small class="text-danger">
                                        short_name:<br>
                                        @foreach($wrestlers_name as $wrestler_name)
                                        {{$wrestler_name->name_short}} ,
                                        @endforeach
                                    </small>
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
