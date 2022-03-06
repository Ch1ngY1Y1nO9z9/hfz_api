@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Banner Management</div>

                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Current banner</th>
                                <th>Alt</th>
                                <th>Features</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><img src="{{$item->img}}" width="200" alt=""></td>
                                    <td>{{$item->alt}}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="/admin/banner/edit/{{ $item->id}}">edit</a>
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
        } );
    </script>

    @if(Session::has('message'))
        <script>
            alert('Update Success!')
        </script>
    @endif
@endsection
