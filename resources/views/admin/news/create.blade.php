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
                                <select class="form-control" id="type" name="type" onchange="change_layout(this.id)">
                                  <option value="news">news</option>
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

                            <hr>

                            <div id="fan_art" class="d-none">
                                <div class="form-group row">
                                    <label for="img" class="col-2 col-form-label">Fan arts file link</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="img" name="img">
                                    </div>
                                    <div class="col-12"><small class="text-danger">*link be like: https://i.ytimg.com/vi/JacN1MzyeKo/hqdefault.jpg <- should have file format at the end</small></div>
                                </div>
                            </div>

                            <div id="video" class="d-none">
                                <div class="form-group row">
                                    <label for="video_from" class="col-2 col-form-label">Video from</label>
                                    <div class="col-10">
                                        <select class="form-control" id="video_from" name="">
                                            <option value="youtube">youtube</option>
                                            <option value="streamable">streamable</option>
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
                                <div class="form-group row">
                                    <label for="content" class="col-2 col-form-label">Video id</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="content" name="content">
                                    </div>
                                </div>
                            </div>


                            <div id="news_layout" class="pb-5">
                                <div class="form-group row">
                                    <label for="news" class="col-2 col-form-label">Content</label>
                                    <div class="col-10">
                                        <textarea style="display:none;" type="text" class="form-control" id="news" name="content"></textarea>
                                        <div id="editor"></div>
                                    </div>
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
                                <span id="check" class="btn btn-primary">Store</span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>

    <script>

        var current_date = new Date();

        var date = current_date.getFullYear() + '/' + (current_date.getMonth() + 1) + '/' + current_date.getDate()

        document.querySelector('input[name="date"]').setAttribute('value', date)

        function change_layout(x){
            var type = document.getElementById(x).value;
            var img_layout = document.getElementById('fan_art');
            var content_layout = document.getElementById('video')
            var img = document.getElementById('img');
            var content = document.getElementById('content')
            var video_from = document.getElementById('video_from')
            var news_layout = document.getElementById('news_layout')
            var news = document.getElementById('news')

            if(type == 'img'){
                content.value = '';
                news.value = '';
                content_layout.classList.add('d-none')
                news_layout.classList.add('d-none')
                img_layout.classList.remove('d-none')
            }else if(type == 'video'){
                img.value = '';
                news.value = '';
                news.setAttribute('name','');
                content.setAttribute('name','content');
                video_from.setAttribute('name','video_from');
                content_layout.classList.remove('d-none')
                img_layout.classList.add('d-none')
                news_layout.classList.add('d-none')
            }else{
                img.value = '';
                content.value = '';
                news.setAttribute('name','content');
                content.setAttribute('name','');
                video_from.setAttribute('name','');
                content_layout.classList.add('d-none')
                img_layout.classList.add('d-none')
                news_layout.classList.remove('d-none')

            }
        }



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
                    [ 'link', 'image'],
                    [ 'clean' ]
                    ],
                },
                theme: 'snow',
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#check').click(function(e){
                var type = $('#type').val();
                $img_count = $('.ql-editor').find('img').length
                var count = 0
                e.preventDefault();

                if(type == 'news'){
                    if($img_count != 0){
                        $('.ql-editor').find('img').map(function(){
                            var img = $(this);
                            $.ajax({
                                method: 'POST',
                                url: '/upload_to_imgru',
                                data: {src:$(this).attr('src')},
                                success: function (res) {
                                    img.attr('src',res);
                                    count += 1;

                                    if($img_count == count){
                                        setTimeout(function(){
                                            const DATA = JSON.stringify( quill.getContents() );
                                            $('#news').html(DATA);
                                            },2000)
                                        setTimeout(function(){$('form').submit();},3200)
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.error(textStatus + " " + errorThrown);
                                }
                            });
                        })
                    }else{
                        const DATA = JSON.stringify( quill.getContents() );
                        $('#news').html(DATA);
                        setTimeout(function(){$('form').submit();},2000);
                    }

                }else{
                    $('form').submit();
                }

            })

        })

    </script>
@endsection
