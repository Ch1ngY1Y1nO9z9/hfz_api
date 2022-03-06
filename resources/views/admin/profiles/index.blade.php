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
                        Profile Management
                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>gen</th>
                                <th>name</th>
                                <th>spamming text</th>
                                <th>Feature</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        @if($item->generations_id != 0)
                                            {{$item->gens->generations}}
                                        @else
                                            Management
                                        @endif
                                    </td>
                                    <td>{{$item->name_en}}</td>
                                    <td style="white-space:pre-line">{{$item->spamming}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm my-1" href="/admin/profile_data/edit/{{$item->id}}">edit profile_data</a>
                                        <a class="btn btn-info btn-sm my-1" href="/admin/profile/{{$item->id}}/clips">edit clips</a>
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
                order: [[ 1, 'desc' ]],
            });
        } );
    </script>
@endsection
