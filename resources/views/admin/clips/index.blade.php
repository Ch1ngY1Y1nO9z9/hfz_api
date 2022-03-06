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
                      {{$wrestler->name_en}} Clips Management
                    </div>

                    <div class="card-body">
                        <a class="btn btn-secondary" href="/admin/profile">Back to Profile</a>
                        <hr>
                        <a class="btn btn-success" href="/admin/profile/{{$wrestler->id}}/clips/create">Create</a>
                        <hr>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Wrestler name</th>
                                <th>Clip Title</th>
                                <th>Sort</th>
                                <th width="80">Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->clips->name_en}}</td>
                                    <td>{{$item->clip_title}}</td>
                                    <td>{{$item->sort}}</td>
                                    <td width="200">
                                        <a class="btn btn-primary btn-sm" href="/admin/profile/{{$item->wrestler_id}}/clips/edit/{{$item->id}}">edit</a>
                                        <a class="btn btn-danger  btn-sm" href="#" data-itemid="{{$item->id}}" href="">delete</a>

                                        <form class="destroy-form" data-itemid="{{$item->id}}"
                                            action="/admin/profile/clips/delete/{{$item->id}}" method="POST"
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
                order: [[ 2, 'desc' ]],
            });

            $('#example').on('click','.btn-danger',function(){
                event.preventDefault();
                var r = confirm("Do you want delete this clip?");
                if (r == true) {
                    var itemid = $(this).data("itemid");
                    $(`.destroy-form[data-itemid="${itemid}"]`).submit();
                }
            });
        } );
    </script>

@endsection
