@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <h4 class="card-header">
                        Contact Us - More
                    </h4>
                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="form-group row">
                                <label for="date" class="col-2 col-form-label">Created_at</label>
                                <div class="col-10">
                                    <input id="date" class="form-control" type="text" readonly value="{{$contact_info->created_at}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country_name" class="col-2 col-form-label">Name</label>
                                <div class="col-10">
                                    <input id="country_name" class="form-control" type="text" readonly value="{{$contact_info->name}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-2 col-form-label">Email</label>
                                <div class="col-10">
                                    <input id="email" class="form-control" type="text" readonly value="{{$contact_info->email}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content" class="col-2 col-form-label">Message</label>
                                <div class="col-10">
                                    <textarea id="content" class="form-control" rows="8" disabled>{{$contact_info->content}}</textarea>
                                </div>
                            </div>

                            <hr>
                        </form>

                        <a href="/admin/contact" class="btn btn-primary d-block col-2 mx-auto">back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
