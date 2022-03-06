@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Stream Records - create</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/stream">back</a>
                        <hr>
                        <form method="POST" action="/admin/stream/store" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="stream_number" class="col-2 col-form-label">Stream episode</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="stream_number" name="stream_number" value="{{$number}}" min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="context1" class="col-2 col-form-label">highlight 1</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="context1" name="context1" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="context2" class="col-2 col-form-label">highlight 2</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="context2" name="context2">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="context3" class="col-2 col-form-label">highlight 3</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="context3" name="context3">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-2 col-form-label">Archived video link</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="link" name="link">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="background_image" class="col-sm-2 col-form-label">Upload Background<br><small
                                        class="text-danger">*recommend size: 770px * 330px </small></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="background_image" value="" name="background_image">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label for="date" class="col-2 col-form-label">Date</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="col-12"><small class="text-danger"></small></div>
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
    @if(Session::has('store'))
        <script>
            alert('store success!')
        </script>
    @endif
@endsection
