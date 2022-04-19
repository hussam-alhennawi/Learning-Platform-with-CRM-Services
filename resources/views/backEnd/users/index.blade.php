@extends('backEnd.layouts.master')
@section('title','List Users')
@section('content')
<div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('users.index')}}" title="Go to Users" class="current">Users</a>@if(isset($role)) <a href="{{url('/admin/users-type/'.$role->id)}}" title="{{$role->display_name}}" class="current">{{$role->display_name}}</a>@endif</div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        @if(isset($roles) && false)
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List Roles</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>Role</th>
                            <th>Count of Users</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr class="gradeC">
                                    <td>{{$role->display_name}}</td>
                                    <td>
                                        {{count($role->users)}}
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{route('usersByRole'.$role->id)}}" class="btn btn-success btn-mini">Check</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(isset($users))
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>List Users</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th>Registered At Collage</th>
                            <th>Identity Check File (For External Students)</th>
                            <th>Courses (For Lecturers)</th>
                            <th>Classes (For Lecturers)</th>
                            <th>Classes (For Internal Students)</th>
                            <th>Fav Lectures (For Internal Students)</th>
                            <th>Fav Lib Projects (For Internal Students)</th>
                            <th>Fav References (For Internal & External Students)</th>
                            <th>Is Verified</th>
                            <th>Is Active</th>
                            <th>Is Blocked</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                
                                <tr class="gradeC">
                                    <td>{{$user->full_name()}}</td>
                                    <td>
                                        @forelse ($user->roles as $role)
                                            {{$role->display_name}}
                                            @if (!$loop->last)
                                                ,<br>
                                            @endif
                                        @empty
                                            No Rules
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse ($user->permissions as $permission)
                                            {{$permission->display_name}}
                                            @if (!$loop->last)
                                                ,<br>
                                            @endif
                                        @empty
                                            No Permissions
                                        @endforelse
                                    </td>
                                    <td>
                                        @if($user->StudentRegistredAtCollage)
                                            {{$user->StudentRegistredAtCollage->date_of_registration}} in {{$user->StudentRegistredAtCollage->collage->name_en}}
                                        @elseif($user->LecturerRegistredAtCollage)
                                            @foreach ($user->LecturerRegistredAtCollage as $reg)
                                                {{$reg->date_of_registration}} in {{$reg->collage->name_en}}<br>                                                
                                            @endforeach
                                        @else
                                            Not Registered
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->identity_check)
                                            <a href="{{Storage::url('PDFfiles/'.$user->identity_check)}}" target="_blank" class="btn btn-success btn-mini">
                                                Download
                                            </a>
                                        @else
                                            No file
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->courses()->count())
                                            <a href="{{route('getCoursesByLec',$user->id)}}" class="btn btn-info btn-mini">{{$user->courses()->count()}} Courses</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->LecturerClasses()->count())
                                            <a href="{{route('getClassesByLecturer',$user->id)}}" class="btn btn-info btn-mini">{{$user->LecturerClasses()->count()}} Classes</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->Classes()->count())
                                            <?php $realClassesIds = [] ?>
                                            @foreach ($user->Classes as $u_c)
                                                @if(!in_array($u_c['class_id'],$realClassesIds))
                                                    <?php $realClassesIds[] = $u_c['class_id'] ?>
                                                @endif
                                            @endforeach
                                            <a href="{{route('getClassesForRegStudent',$user->id)}}" class="btn btn-info btn-mini">{{count($realClassesIds)}}</a>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->FavouriteLectures()->count())
                                            {{$user->FavouriteLectures()->count()}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->FavouriteLibProjects()->count())
                                            {{$user->FavouriteLibProjects()->count()}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->FavouriteReferences()->count())
                                            {{$user->FavouriteReferences()->count()}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        {{($user->email_verified_at)?$user->email_verified_at:'No'}}
                                    </td>
                                    <td>
                                        {{(!$user->is_active())?'Inactive':'Active'}}
                                    </td>
                                    <td>
                                        {{($user->is_blocked())?'Blocked':'Not Blocked'}}
                                    </td>
                                    <td style="text-align: left;">
                                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-mini">Edit Roles&Permissions</a>
                                        <a href="#myModal{{$user->id}}" data-toggle="modal" class="btn btn-info btn-mini">View</a>
                                        @if(!$user->is_active())
                                            <a href="{{route('ActivateUser',$user->id)}}" class="btn btn-success btn-mini">Activate</a>
                                        @else
                                            <a href="{{route('DeactivateUser',$user->id)}}" class="btn btn-warning btn-mini">Deactivate</a>
                                        @endif
                                        @if($user->is_blocked())
                                            <a href="{{route('unblockUser',$user->id)}}" class="btn btn-danger btn-mini">Unblock</a>
                                        @else
                                            <a href="{{route('BlockUser',$user->id)}}" class="btn btn-danger btn-mini">Block</a>
                                        @endif
                                    </td>
                                </tr>
                                <!--Pop Up Model for View User-->
                                <div id="myModal{{$user->id}}" class="modal hide">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>{{$user->full_name()}}</h3>
                                    </div>
                                    <div class="modal-body">
                                        @if($user->image)
                                            <div class="text-center" style="margin:5px;">
                                                <img src="{{url('/photos/profiles')}}/{{$user->image}}" width="300" alt="user image">
                                            </div>
                                        @endif    
                                        <p class="text-center">Date of Birth : {{$user->DOB}}</p>
                                        <p class="text-center">E-mail : {{$user->email}}</p>
                                        <p class="text-center">Phone Number : {{$user->phone}}</p>
                                        <p class="text-center">Gender : {{$user->gender}}</p>
                                    </div>
                                </div>
                                <!--Pop Up Model for View User Details-->
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                </div>
            </div>
        @endif
    </div>
@endsection
@section('jsblock')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.ui.custom.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.uniform.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/matrix.js')}}"></script>
    <script src="{{asset('js/matrix.tables.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        
    </script>
@endsection