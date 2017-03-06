{{ csrf_field() }}

<div class="row">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Account Information</h3>
            <p class="text-muted m-b-30 font-13">Enter account info for the user</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ti-user"></i></div>
                            <input type="text" name="username" class="form-control" placeholder="username"
                                   value="{{ $user->username or old('username') }}">
                        </div>
                        @if($errors->has('username'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ti-email"></i></div>
                            <input type="text" name="email" class="form-control" placeholder="email"
                                   value="{{ $user->email or old('email') }}">
                        </div>
                        @if($errors->has('email'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="ti-lock"></i></div>
                            <input type="password" name="password" class="form-control" placeholder="password">
                        </div>
                        {{--<span class="help-block">--}}
                                        {{--<small>Leave empty if you do not wish to change it.</small>--}}
                                    {{--</span>--}}

                        @if($errors->has('password'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Role <span class="text-danger">*</span></label>
                        <select class="form-control" name="role">
                            <option value="">-- Select Role --</option>
                            @foreach(\App\User::$roles as $roleSlug => $roleTitle)
                                <option value="{{ $roleSlug }}" {{ isset($user) ? ($user->role == $roleSlug ? 'selected' : '') : '' }}>{{ $roleTitle }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Personal Information</h3>
            <p class="text-muted m-b-30 font-13">Enter personal info for the user</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="col-xs-12">Profile picture</label>
                        <div class="col-xs-12">

                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="avatar" accept="image/*">
                                        </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                   data-dismiss="fileinput">Remove</a>
                            </div>

                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="John"
                               value="{{ $user->first_name or old('first_name') }}">
                        @if($errors->has('first_name'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" placeholder="Doe"
                               value="{{ $user->last_name or old('last_name') }}">
                        @if($errors->has('last_name'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Gender <span class="text-danger">*</span></label>
                        <div class="radio-list">
                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="gender" value="1" id="male" {{ isset($user) ? ($user->gender == 1 ? 'checked' : '') : 'checked'  }}>
                                    <label for="male">Male</label>
                                </div>
                            </label>
                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="gender" value="2" id="female" {{ isset($user) ? ($user->gender == 2 ? 'checked' : '') : ''  }}>
                                    <label for="female">Female</label>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>