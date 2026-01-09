@extends('theme::dashboard.layouts.app')
@section('page-title')
    {{__('Galleries')}}
@endsection
@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{url('/')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active">{{__('Galleries')}}</li>
@endsection
@section('body')

    <div class="col-lg-12 m-auto">
        <div class="card">
            <div class="card-header border-0">
                <a href="{{url('dashboard/gallery/new')}}" type="button" class="btn btn-primary">
                    {{__('Add  Gallery')}}
                </a>

            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-valign-middle">
                    <thead>
                    <tr>
                        <th>{{__('SN')}}</th>

                        <th>{{__('Title')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Published')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($galleries as $gallery)
                        @php
                            $count = (string)$loop->iteration;
                        @endphp
                        <tr>
                            <td>{{__($count)}}</td>

                            <td>

                                       {{ $gallery->title }}
                            </td>
                            <td>

                                {!! $gallery->description  !!}
                            </td>
                            <td>
                                <input type="checkbox" disabled
                                       {{ $gallery->is_published ? 'checked' : '' }} class="ml-4">
                            </td>

                            <td>

                                <form class="d-inline" action="{{url("dashboard/gallery/edit")}}" method="GET">
                                    <input type="hidden" name="id" value="{{$gallery->id}}">
                                    <button class="btn" data-toggle="tooltip" data-placement="bottom"
                                            title="{{__('Edit')}}">
                                        <i class="fa-solid fa-pen-to-square" style="color: #007bff"></i>
                                    </button>
                                </form>
                                <form class="d-inline" action="{{url("dashboard/gallery/add-images")}}" method="GET">
                                    <input type="hidden" name="id" value="{{$gallery->id}}">
                                    <button class="btn" data-toggle="tooltip" data-placement="bottom"
                                            title="{{__('Add Images')}}">
                                        <i class="fa-solid fa-image" style="color: #007bff"></i>
                                    </button>
                                </form>
                                <form class="d-inline" action="{{url("dashboard/gallery/delete/$gallery->id")}}"
                                      method="POST"
                                      class="d-inline" onsubmit="return confirmDeletion();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                            title="{{__('Delete')}}" class="ml-2 btn"><i style="color: red"
                                                                                         class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    function confirmDeletion() {
        return confirm('Are you sure you want to delete this gallery?');
    }
</script>

