@extends('backEnd.layouts.master')
@section('title','Edit User')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('users.index')}}">Users</a> <a href="#" class="current">Edit User</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit User</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('users.update',$user->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            <div class="control-group">
                                <label class="control-label">Roles :</label>
                                <div class="controls" style="width: 245px;">
                                    @foreach($Roles as $role)
                                        <input name="roles[]" type="checkbox" value="{{$role->id}}" {{($user->hasRole($role->name))?' checked':''}}>{{$role->display_name}}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Permissions :</label>
                                <div class="controls" style="width: 245px;">
                                    @foreach($Permissions as $permission)
                                        <input name="permissions[]" type="checkbox" value="{{$permission->id}}" {{($user->isAbleTo($permission->name))?' checked':''}}>{{$permission->display_name}}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="control-label"></label>
                                <div class="controls">
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.custom.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/matrix.js') }}"></script>
    <script src="{{ asset('js/matrix.form_validation.js') }}"></script>
    <script src="{{ asset('js/matrix.tables.js') }}"></script>
    <script src="{{ asset('js/matrix.popover.js') }}"></script>
@endsection