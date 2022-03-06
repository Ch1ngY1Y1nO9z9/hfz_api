@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      Stream records Management
                    </div>

                    <div class="card-body">
                        @if(Auth::user()->role == 'admin')
                            <a class="btn btn-success" href="/admin/stream/create">Create</a>
                            <hr>
                        @endif

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Stream episode</th>
                                <th>Context</th>
                                <th>background image</th>
                                <th width="80">Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>Stream {{$item->stream_number}}</td>
                                    <td>
                                        <ul>
                                            <li>{{$item->context1}}</li>
                                            <li>{{$item->context2}}</li>
                                            <li>{{$item->context3}}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{$item->background_image}}" data-lightbox="stream background" data-title="stream background">
                                            <img src="{{$item->background_image}}" width="200" alt="">
                                        </a>

                                    </td>
                                    <td width="200">
                                        <a class="btn btn-primary btn-sm" href="/admin/stream/edit/{{$item->id}}">edit</a>
                                        <a class="btn btn-success btn-sm my-1" href="/admin/stream/match_result/{{$item->stream_number}}">match result</a>
                                        <a class="btn btn-info btn-sm my-1" href="/admin/stream/song_list/{{$item->stream_number}}">song list</a>
                                        {{-- <a class="btn btn-danger  btn-sm" href="#" data-itemid="{{$item->id}}" href="">delete</a> --}}

                                        <form class="destroy-form" data-itemid="{{$item->id}}"
                                            action="/admin/stream/delete/{{$item->id}}" method="POST"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                order: [[ 3, 'desc' ]],
            });

        } );
    </script>

@endsection
