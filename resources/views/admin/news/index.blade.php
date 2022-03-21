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
                        News Management
                    </div>

                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/news/create">Create</a>
                        <hr>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>type</th>
                                <th>Description / Fan arts</th>
                                <th>Date</th>
                                <th>Sort</th>
                                <th width="80">Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($news_lists as $news)
                                <tr>

                                    <td>{{$news->title}}</td>
                                    <td>{{$news->type}}@if($news->type == 'video') - {{$news->video_from}}@endif</td>
                                    <td>
                                        @if($news->type == 'img')
                                            <img src="{{$news->thumbnail}}" width="200" alt="">
                                        @else
                                            {{$news->description}}
                                        @endif
                                    </td>
                                    <td>{{$news->date}}</td>
                                    <td>{{$news->sort}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="/admin/news/edit/{{$news->id}}">edit</a>
                                        <a class="btn btn-danger  btn-sm" href="#" data-itemid="{{$news->id}}" href="">delete</a>

                                        <form class="destroy-form" data-itemid="{{$news->id}}"
                                            action="/admin/news/delete/{{$news->id}}" method="POST"
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
            $('#example').DataTable({
                order: [[ 3, 'desc' ]],
            });

            $('#example').on('click','.btn-danger',function(){
                event.preventDefault();
                var r = confirm("Do you want delete this news?");
                if (r == true) {
                    var itemid = $(this).data("itemid");
                    $(`.destroy-form[data-itemid="${itemid}"]`).submit();
                }
            });
        } );
    </script>

    @if(Session::has('store'))
        <script>
            alert('store success!')
        </script>
    @endif

    @if(Session::has('update'))
        <script>
            alert('update success!')
        </script>
    @endif

@endsection
