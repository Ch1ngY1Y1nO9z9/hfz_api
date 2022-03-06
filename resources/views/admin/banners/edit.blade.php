@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Banner - Edit</div>

                <div class="card-body">
                    <form method="post" action="/admin/banner/update/{{$items->id}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Current Banner</label>
                            <div class="col-sm-10 mb-3">
                                <img width="200px" src="{{$items->img}}" alt="">
                            </div>
                            <label for="img" class="col-sm-2 col-form-label">Upload New Banner<br><small
                                    class="text-danger">*Picture size: 1920px * 1080px </small></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="img" value="" name="img">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="alt" class="col-sm-2 col-form-label">Alt</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alt" value="{{$items->alt}}" name="alt" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
@endsection
