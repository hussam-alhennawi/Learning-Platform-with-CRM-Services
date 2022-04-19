<!--sidebar-menu-->
<div id="sidebar"><a href="{{route('management')}}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li><a href="{{route('/')}}">Back To Home</a></li>

        @role('superadministrator')
        <li class="submenu {{$menu_active==='users'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span></a>
            <ul>
                @foreach ($roles as $role)
                    <li><a href="{{route('usersByRole',$role->id)}}">{{$role->display_name}}s</a></li>
                @endforeach
                <li><a href="{{route('users.create')}}">Add New User</a></li>
            </ul>
        </li>
        @endrole
        @role('superadministrator')
        <li class="submenu {{$menu_active==='collages'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Collages</span></a>
            <ul>
                <li><a href="{{route('collages.index')}}">List Collages</a></li>
                <li><a href="{{route('collages.create')}}">Add New Collage</a></li>
            </ul>
        </li>
        @endrole
        @role('superadministrator')
        <li class="submenu {{$menu_active==='subjects'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Subjects</span></a>
            <ul>
                <li><a href="{{route('subjects.index')}}">List Subjects</a></li>
                <li><a href="{{route('subjects.create')}}">Add New Subject</a></li>
            </ul>
        </li>
        @endrole
        @role('superadministrator')
        <li class="submenu {{$menu_active==='classes'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Classes</span></a>
            <ul>
                <li><a href="{{route('classes.index')}}">List Classes</a></li>
                <li><a href="{{route('classes.create')}}">Add New Class</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Lecturer'])
        <li class="submenu {{$menu_active==='lectures'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Lectures</span></a>
            <ul>
                <li><a href="{{route('lectures.index')}}">List Lectures</a></li>
                <li><a href="{{route('lectures.create')}}">Add New Lecture</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Employee'])
        <li class="submenu {{$menu_active==='events'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Events</span></a>
            <ul>
                <li><a href="{{route('events.index')}}">List Events</a></li>
                <li><a href="{{route('events.create')}}">Add New Event</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Librarian','Lecturer'])
        <li class="submenu {{$menu_active==='references'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>References</span></a>
            <ul>
                <li><a href="{{route('references.index')}}">List References</a></li>
                <li><a href="{{route('references.create')}}">Add New Reference</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Librarian','Lecturer'])
        <li class="submenu {{$menu_active==='lib_projects'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Library Projects</span></a>
            <ul>
                <li><a href="{{route('lib_projects.index')}}">List Library Projects</a></li>
                <li><a href="{{route('lib_projects.create')}}">Add New Library Project</a></li>
            </ul>
        </li>
        @endrole
        @role('superadministrator')
        <li class="submenu {{$menu_active==='categories'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span></a>
            <ul>
                <li><a href="{{route('categories.index')}}">List Categories</a></li>
                <li><a href="{{route('categories.create')}}">Add New Category</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Lecturer'])
        <li class="submenu {{$menu_active==='courses'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Courses</span></a>
            <ul>
                <li><a href="{{route('courses.index')}}">List Courses</a></li>
                <li><a href="{{route('courses.requests')}}">New Requests For Courses</a></li>
                <li><a href="{{route('courses.create')}}">Add New Course</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Lecturer'])
        <li class="submenu {{$menu_active==='topics'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Topics</span></a>
            <ul>
                <li><a href="{{route('topics.index')}}">List Topics</a></li>
                <li><a href="{{route('topics.create')}}">Add New Topic</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Lecturer'])
        <li class="submenu {{$menu_active==='contents'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Contents</span></a>
            <ul>
                <li><a href="{{route('contents.index')}}">List Contents</a></li>
                <li><a href="{{route('contents.create')}}">Add New Content</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator','Employee'])
        <li class="submenu {{$menu_active==='advertisements'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Advertisements</span></a>
            <ul>
                <li><a href="{{route('advertisements.index')}}">List Advertisements</a></li>
                <li><a href="{{route('advertisements.create')}}">Add New Advertisement</a></li>
            </ul>
        </li>
        @endrole
        @role(['superadministrator'])
        <li class="submenu {{$menu_active==='complaints'? ' active':''}}"> <a href="#"><i class="icon icon-th-list"></i> <span>Complaints</span></a>
            <ul>
                <li><a href="{{route('complaints.index')}}">List Complaints</a></li>
            </ul>
        </li>
        @endrole
    </ul>
</div>
<!--sidebar-menu-->