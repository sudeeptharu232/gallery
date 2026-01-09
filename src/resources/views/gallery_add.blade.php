@extends('theme::dashboard.layouts.app')
@section('page-title')
    {{__('Galleries')}}
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{url('/')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active"><a href="{{url('/dashboard/galleries')}}">{{__('Galleries')}}</a></li>
    <li class="breadcrumb-item active">{{__('Create')}}</li>
@endsection
@section('body')
    <div class="col-lg-12 m-auto">
        <form action="{{url('dashboard/gallery/create')}}" method="POST">

        <div class="card card-default">
            <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" placeholder="{{__('Title')}}" class="form-control" id="title" name="title">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="is_published" value="0">
                                <input class="custom-control-input" name="is_published" type="checkbox" id="customCheckbox1" value="1">
                                <label for="customCheckbox1" class="custom-control-label">{{__('Published')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 form-group">

                            <label>Description</label>
                            <textarea name="description" id="description" class="editor" rows="17"
                                      cols="95"></textarea>
                        </div>

                    </div>
                    <div class="row">

                    </div>


            </div>
            <div class="card-footer">
                <button type="submit"
                        class="btn btn-primary justify-content-center">{{__('Submit')}}</button>
            </div>
        </div>
        </form>

    </div>

@endsection


