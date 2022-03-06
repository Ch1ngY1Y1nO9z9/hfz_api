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
                      Stream {{$stream_number}} Song list Management
                    </div>

                    <div class="card-body">
                        <a class="btn btn-secondary" href="/admin/stream">Back to Stream Management</a>
                        <hr>
                        <a class="btn btn-success" href="/admin/stream/song_list/{{$stream_number}}/create">Create</a>
                        <hr>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>game</th>
                                <th>link</th>
                                <th width="80">Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->played_at}}</td>
                                    <td>
                                        <iframe width="100%" height="300" src="https://www.youtube.com/embed/{{$item->link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                    </td>
                                    <td width="200">
                                        <a class="btn btn-primary btn-sm" href="/admin/stream/song_list/edit/{{$item->id}}">edit</a>
                                        <a class="btn btn-danger  btn-sm" href="#" data-itemid="{{$item->id}}" href="">delete</a>

                                        <form class="destroy-form" data-itemid="{{$item->id}}"
                                            action="/admin/stream/song_list/delete/{{$item->id}}" method="POST"
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
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            $('#example').on('click','.btn-danger',function(){
                event.preventDefault();
                var r = confirm("Do you want delete this song?");
                if (r == true) {
                    var itemid = $(this).data("itemid");
                    $(`.destroy-form[data-itemid="${itemid}"]`).submit();
                }
            });
        } );
    </script>

@endsection
