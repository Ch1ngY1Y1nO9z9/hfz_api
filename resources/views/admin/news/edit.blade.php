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

                            @if($news->type == 'img')
                                <div id="fan_art">
                                    <div class="form-group row">
                                        <label for="img" class="col-2 col-form-label">Fan arts file link</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="img" name="img" @if($news->type == 'img') value="{{$news->img}}" @endif>
                                        </div>
                                        <div class="col-12"><small class="text-danger">*link be like: https://i.ytimg.com/vi/JacN1MzyeKo/hqdefault.jpg <- should have file format at the end</small></div>
                                    </div>
                                </div>
                            @elseif($news->type == 'video')
                                <div id="video">
                                    <div class="form-group row">
                                        <div class="form-group row">
                                            <label for="video_from" class="col-2 col-form-label">Video from</label>
                                            <div class="col-10">
                                                <select class="form-control" id="video_from" name="video_from">
                                                    <option value="youtube" @if($news->video_from == 'youtube') selected @endif>youtube</option>
                                                    <option value="streamable" @if($news->video_from == 'streamable') selected @endif>streamable</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <small class="text-danger">
                                                    *Video id only, don't put embed code<br>
                                                    video id guide: <br>
                                                    <img src="/images/embedcode_guide.jpg" alt="">
                                                    <img src="/images/youtube_video_example.jpg" alt="">
                                                </small>
                                            </div>
                                        </div>
                                        <label for="content" class="col-2 col-form-label">Content</label>
                                        <div class="col-10">
                                            <textarea style="height:150px;" type="text" class="form-control" id="content" name="content">{{$news->content}}</textarea>
                                        </div>
                                        <div class="col-12"><small class="text-danger">*If you want put OC video, streamable.com embed code ONLY</small></div>
                                    </div>
                                </div>
                            @else
                                <div id="news_layout" class="pb-5">
                                    <div class="form-group row">
                                        <label for="news" class="col-2 col-form-label">Content</label>
                                        <div class="col-10">
                                            <textarea style="display:none;" type="text" class="form-control" id="news" name="content">{{$news->content}}</textarea>
                                            <div id="editor"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>
                            <div class="form-group row">
                                <label for="sort" class="col-2 col-form-label">Sort</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" id="sort" name="sort" value="{{$news->sort}}" required min="0" max="999">
                                </div>
                            </div>
                            <hr>
                            @if($news->type == 'news')
                            <div class="d-flex justify-content-center">
                                <span id="check" class="btn btn-primary">Store</span>
                            </div>
                            @else
                            <button type="submit" class="btn btn-primary d-block mx-auto">update</button>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    @if($news->type == 'news')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>
    <script>
        $(document).ready(function(){
            var quill = new Quill('#editor', {
                bounds: '#editor',
                modules: {
                    imageResize: {
                        displaySize: true
                    },
                    syntax: true,
                    toolbar: [
                    [{ 'size': [] }],
                    [ 'bold', 'italic', 'underline', 'strike' ],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'super' }, { 'script': 'sub' }],
                    [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
                    [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
                    [ {'direction': 'rtl'}, { 'align': [] }],
                    [ 'link'],
                    [ 'clean' ]
                    ],
                },
                theme: 'snow',
            });

            function check_json(str) {
                try {
                    JSON.parse(str);
                } catch (e) {

                    return false;
                }
                return true;
            };

            content = $('#news').html()

            if( check_json(content) ) {
                quill.setContents(JSON.parse( content ).ops);
            }else {
                quill.setText(content);
            }


            $('#check').click(function(e){
                e.preventDefault();
                const DATA = JSON.stringify( quill.getContents() );
                $('#news').html(DATA);
                setTimeout(function(){$('form').submit();},1000)
            })

        })
    </script>

    @endif
@endsection


