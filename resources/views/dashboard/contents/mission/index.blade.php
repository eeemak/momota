@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <h4 class="page-title">Missions</h4>
        </div>
        <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Mission</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table datatable">
                    <thead>
                        <tr>
                            <th style="width: 15px">#</th>
                            <th>Mission</th>
                            <th style="width: 100px">Featured</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 50px" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mission_list as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="product-det">
                                    <img src="{{ asset($item->image_path ?? 'images/no-image.png') }}" alt="image" style="height: 50px; width: 50px; margin-top: -5px;">
                                    <div class="product-desc">
                                        <h2><a href="#">{{ $item->name }}</a> <span>{{ $item->description }} </span></h2></div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->featured ? 'text-success' : 'text-primary' }}"></i> {{ $item->featured ? 'Featured' : 'Normal' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> Featured</a></li>
                                        <li><a href="#"><i class="fa fa-dot-circle-o text-primary"></i> Normal</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->active ? 'text-success' : 'text-danger' }}"></i> {{ $item->active ? 'Active' : 'Inactive' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a></li>
                                        <li><a href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('mission.edit', $item) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="create" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Create Mission</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('mission.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>Mission Title</label>
                        <input name="name" class="form-control" type="text" value="{{ old('name') }}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>Description</label>
                        <textarea name="description" rows="4" cols="5" class="form-control summernote" placeholder="Enter your description here">{{ old('description') }}</textarea>
                        <small class="text-danger">{{ $errors->first('description') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                        <label>Upload Files</label>
                        <input name="image" class="form-control" type="file">
                        <small>Max: {{ config('dashboard.modules.mission.upload_max_file_size') }} KB</small>
                        <small class="text-danger">{{ $errors->first('image') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Featured</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="featured" value="1"> Featured
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="featured" checked="checked" value="0"> Normal
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Active</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="active" checked="checked" value="1"> Active
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="active" value="0"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Create Mission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="delete_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h4 class="modal-title">Delete Mission</h4>
            </div>
            <div class="modal-body card-box">
                <p>Are you sure want to delete this?</p>
                <div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script>
        @if(count($errors) > 0)
        $('#create').modal('show')
        @endif
    </script>
@endsection