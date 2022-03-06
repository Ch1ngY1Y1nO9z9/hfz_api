@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <h4 class="card-header">
                        SEO Management
                    </h4>
                    <div class="card-body">
                        <form action="/admin/seo" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title" class="col-form-label">Website title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$seo->title}}" required>
                            </div>
                            <div class="form-group">
                                <label for="keyword" class="col-form-label">Keyword for Search engine</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="keyword, keyword1, keyword2" value="{{$seo->keyword}}" required>
                                <small class="text-danger">example:keyword, keyword1, keyword2</small>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-form-label">Website Description</label>
                                <input type="text" class="form-control" id="description" name="description" value="{{$seo->description}}" required>
                            </div>
                            <hr>
                            <div class="offset-5 col-2 text-center">
                                <button class="btn btn-success">Update</button>
                            </div>
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
                order: [[ 2, 'desc' ]]
            });
        } );

    </script>

    @if(Session::has('message'))
        <script>
            alert('success!')
        </script>
    @endif
@endsection
