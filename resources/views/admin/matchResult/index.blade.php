@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    Stream {{$id}} Match results Management
                    </div>

                    <div class="card-body">
                        <a class="btn btn-secondary" href="/admin/stream">back to Stream Management</a>
                        <hr>
                        <a class="btn btn-success" href="#Create_match">Create</a>
                        <hr>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Game</th>
                                <th>Type</th>
                                <th>Participants</th>
                                <th>Result</th>
                                <th width="80">Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->game}}</td>
                                    <td>
                                        {{$item->type}}
                                    </td>
                                    <td>
                                        {{$item->participants}}
                                    </td>
                                    <td>
                                        {{$item->result}}
                                    </td>
                                    <td width="200">
                                        <a class="btn btn-primary btn-sm" href="/admin/stream/match_result/{{$id}}/edit/{{$item->id}}">edit</a>
                                        <a class="btn btn-danger  btn-sm" href="#" data-itemid="{{$item->id}}" href="">delete</a>

                                        <form class="destroy-form" data-itemid="{{$item->id}}"
                                            action="/admin/stream/match_result/delete/{{$item->id}}" method="POST"
                                            style="display: none;">
                                          @csrf
                                      </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="Create_match">
                <div class="card">
                    <div class="card-header">Create New Record</div>
                    <div class="card-body">
                        <hr>
                        <form method="POST" action="/admin/stream/match_result/{{$id}}/store" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="stream_id" value="{{$id}}">

                            <div class="form-group row">
                                <label for="game" class="col-2 col-form-label">Game</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="game" name="game" @if($records_number == 0) value="1" @else value="{{$records_number+1}}" @endif min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="type">Type</label>
                                <div class="col-10">
                                    <select class="form-control" id="type" name="type">
                                        <option value="1v1">1v1</option>
                                        <option value="2v2">2v2</option>
                                        <option value="MULTi">MULTi</option>
                                      </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rule" class="col-2 col-form-label">Context</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="rule" name="rule" required>
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
                                    <input type="text" class="form-control" id="participants" name="participants" required>
                                    <div class="col-12">
                                        <small class="text-danger">
                                            1v1 format example: Yagoo,Miko<br>
                                            2v2 format example: Sora,A-chan / Suisei,AZKi
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="result" class="col-2 col-form-label">Result</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="result" name="result" required>
                                    <div class="col-12">
                                        <small class="text-danger">
                                            put Winner short name from down below or put DRAW
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
                            <button type="submit" class="btn btn-primary d-block mx-auto">Store</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                order: [[ 4, 'asc' ]],
                "lengthMenu": [[-1], ["All"]]
            });

            $('#example').on('click','.btn-danger',function(){
                event.preventDefault();
                var r = confirm("Do you want delete this match result?");
                if (r == true) {
                    var itemid = $(this).data("itemid");
                    $(`.destroy-form[data-itemid="${itemid}"]`).submit();
                }
            });
        } );
    </script>

@endsection
