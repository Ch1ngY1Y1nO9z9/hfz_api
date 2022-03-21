@extends('layouts.app')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">News - create</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/news">back</a>
                        <hr>
                        <form method="POST" action="/admin/news/store" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="date" value="">

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" id="type" name="type">
                                  <option value="img">fan art</option>
                                  <option value="video">video</option>
                                </select>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label for="title" class="col-2 col-form-label">Title</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="description" name="description" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="img" class="col-2 col-form-label">Fan arts file link / youtube vod id</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="img" name="img">
                                </div>
                            </div>

                            <hr>
                            <div class="form-group row">
                                <label for="sort" class="col-2 col-form-label">Sort</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="sort" name="sort" required value="0" min="0" max="999">
                                </div>
                                <div class="col-12"><small class="text-danger"></small></div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary">Store</button>
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
