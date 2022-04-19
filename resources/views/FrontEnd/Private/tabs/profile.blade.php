<div class="tab-pane fade active in" id="Personal">
    <h3 class="title-section title-bar-high mb-40">Personal Information</h3>
    <div class="personal-info">
        <div class="form-group">
            <label class="col-sm-3 control-label">First Name</label>
            <div class="col-sm-9">
                <input class="form-control" id="first-name" type="text" name="first_name" value="{{$user->first_name}}">
                <span class="text-danger" id="first_name" style="color: red;">{{$errors->first('first_name')}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Mid Name</label>
            <div class="col-sm-9">
                <input class="form-control" id="mid-name" type="text" name="middle_name" value="{{$user->middle_name}}">
                <span class="text-danger" id="middle_name" style="color: red;">{{$errors->first('middle_name')}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Last Name</label>
            <div class="col-sm-9">
                <input class="form-control" id="last-name" type="text" name="last_name" value="{{$user->last_name}}">
                <span class="text-danger" id="last_name" style="color: red;">{{$errors->first('last_name')}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Address</label>
            <div class="col-sm-9">
                <input class="form-control" id="address" type="text" name="address" value="{{$user->address}}">
                <span class="text-danger" id="address" style="color: red;">{{$errors->first('address')}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Image</label>
            <div class="col-sm-9 public-profile-content">
                <img class="img-responsive" src="{{url('/photos/profiles')}}/{{$user->image}}" alt="Image">
                <div class="file-title">Upload a new image:</div>
                <input type="file" name="image" accept=".jpg, .jpeg, .png" id="image"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Change Password</label>
            <div class="col-sm-9">
                <input class="form-control mb-10" name="old_password" id="current-password" type="password" placeholder="Current Password">
                <span class="text-danger" id="old_password" style="color: red;">{{$errors->first('old_password')}}</span>
                <input class="form-control mb-10" name="new_password" id="new-password" type="password" placeholder="New Password">
                <span class="text-danger" id="new_password" style="color: red;">{{$errors->first('new_password')}}</span>
                <input class="form-control mb-10" name="new_password_confirmation" id="confirm-password" type="password" placeholder="Repeat Password">
                <span class="text-danger" id="new_password_confirmation" style="color: red;">{{$errors->first('new_password_confirmation')}}</span>
            </div>
        </div>
        <div class="form-group mb-none">
            <div class="col-sm-offset-3 col-sm-9">
                <button class="view-all-accent-btn disabled col-sm-9" type="submit" value="Login">Save</button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-9 public-profile-content">
            <div class="file-title">{{Session::get('message')}}</div>
        </div>
    </div>
</div>