@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$wrestler->name_short}} - data edit</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/profile">back</a>
                        <hr>
                        <form method="POST" action="/admin/profile_data/update/{{$item->id}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="birth_day" class="col-2 col-form-label">birth day</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="birth_day" name="birth_day" value="{{$item->birth_day}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="debut" class="col-2 col-form-label">debut</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="debut" name="debut" value="{{$item->debut}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weight" class="col-2 col-form-label">weight</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="weight" name="weight" value="{{$item->weight}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fan_name" class="col-2 col-form-label">fan name</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="fan_name" name="fan_name" value="{{$item->fan_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="signature" class="col-2 col-form-label">signature</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="signature" name="signature" value="{{$item->signature}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="finisher" class="col-2 col-form-label">finisher</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="finisher" name="finisher" value="{{$item->finisher}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tag_with" class="col-2 col-form-label">tag with</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="tag_with" name="tag_with" value="{{$item->tag_with}}">
                                </div>
                                <div class="col-12">
                                    <small class="text-danger">
                                        *ONLY ONE WRESTLER SHORT NAME, And please copy from down below, for front-end page link to team mate page<br>
                                        WILL UPDATE.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="team_name" class="col-2 col-form-label">team name</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="team_name" name="team_name" value="{{$item->team_name}}">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="toindex" class="col-2 col-form-label">Rising Star?</label>
                                <div class="col-10">
                                    <input class="form-check-input" type="checkbox" @if($wrestler->toindex == 1) checked="true" @endif value="1" id="toindex" name="toindex">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isHolochampion" class="col-2 col-form-label">Holo Champion?</label>
                                <div class="col-10">
                                    <input class="form-check-input" type="checkbox" @if($wrestler->isHolochampion == 1) checked="true" @endif value="1" id="isHolochampion" name="isHolochampion">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isTagTeamChampion" class="col-2 col-form-label">Tag Champion?</label>
                                <div class="col-1">
                                    <input class="form-check-input" type="checkbox" @if($wrestler->isTagTeamChampion == 1) checked="true" @endif value="1" id="isTagTeamChampion" name="isTagTeamChampion" onclick="check()">
                                </div>
                                <label for="team_mate" class="col-2 col-form-label">With?</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" id="team_mate" name="team_mate" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 text-danger">
                                    *Please copy the short name to put in input, onegai...
                                </div>
                                <div class="col-12">
                                    <small class="text-danger">
                                        short_name:<br>
                                        @foreach($all_wrestler as $wrestlers)
                                            {{$wrestlers->name_short}} ,
                                        @endforeach
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isQoj" class="col-2 col-form-label">Queen of jobber?</label>
                                <div class="col-10">
                                    <input class="form-check-input" type="checkbox" @if($wrestler->isQoj == 1) checked="true" @endif value="1" id="isQoj" name="isQoj">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="haveBriefcase" class="col-2 col-form-label">Have breifcase?</label>
                                <div class="col-10">
                                    <input class="form-check-input" type="checkbox" @if($wrestler->haveBriefcase == 1) checked="true" @endif value="1" id="haveBriefcase" name="haveBriefcase">
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
    @if(Session::has('message'))
        <script>
            alert('update success!')
        </script>
    @endif

    <script>
        function check(){
            var tag_champion = document.getElementById('isTagTeamChampion')
            var team_mate = document.getElementById('team_mate')

            if(tag_champion.checked){
                team_mate.setAttribute('required','true')
            }else{
                team_mate.removeAttribute('required');
            }
        }

    </script>
@endsection
