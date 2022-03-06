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
                    Rank management
                    </div>

                    <form method="POST" action="/admin/rank/update" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary d-block mx-auto">Update</button>
                            <div class="col-12 text-danger">
                                *You can use "Search" on the right side to check out no number is duplicate.<br>
                                PLEASE UPDATE ALL WRESTLERS RANK IN ONE TIME.
                            </div>
                            <hr>
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>rank</th>
                                    <th>name</th>
                                    <th>this week rank:</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->rank}}</td>
                                        <td>
                                            {{$item->name_short}}
                                            <input type="hidden" class="form-control" id="wrestler_id" name="wrestler_id[]" value="{{$item->id}}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="rank" name="rank[]" required value="{{$item->rank}}" min="0" max="999">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

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
                order: [[ 0, 'asc' ]],
                "lengthMenu": [[-1], ["All"]]
            });

            $('.btn-primary').on('click',function(){
                event.preventDefault();
                var r = confirm("Update will automatically update old rank data to last week rank and compare with new rank data, ARE YOU SURE TO UPDATE?");
                if (r == true) {
                    $('form').submit();
                }
            });
        } );
    </script>

    @if(Session::has('update'))
        <script>
            alert('update success!')
        </script>
    @endif

@endsection
