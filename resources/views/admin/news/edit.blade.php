@extends('layouts.app')

@section('css')
    @if($news->type == 'news')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endif
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">News - edit</div>

                    <div class="card-body">
                        <a class="btn btn-success" href="/admin/news">back</a>
                        <hr>
                        <form method="POST" action="/admin/news/update/{{$news->id}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="date" value="{{$news->date}}">

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" id="type" name="type" disabled>
                                  <option value="{{$news->type}}" selected>{{$news->type}}</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-2 col-form-label">Title</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="title" name="title" value="{{$news->title}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="description" name="description" value="{{$news->description}}" required>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <label for="img" class="col-2 col-form-label">Fan arts file link / youtube vod id</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="img" name="img" value="{{$news->img ?: $news->content}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sort" class="col-2 col-form-label">Sort</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="sort" name="sort" value="{{$news->sort}}" required min="0" max="999">
                                </div>
                            </div>
                            <hr>

                            <button type="submit" class="btn btn-primary d-block mx-auto">update</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')

@endsection


