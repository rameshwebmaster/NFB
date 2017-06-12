<div class="row">
    <div class="col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Account Details</h3>
            <p class="text-muted m-b-5">Enter user's account details</p>
            {{--@if($isEdit)--}}
            {{--<p class="text-warning m-b-20">Don't edit these fields if you don't wish to change them.</p>--}}
            {{--@endif--}}

            <div class="row">
                <div class="col-md-4 col-sm-12">

                    <input type="hidden" name="role" value="consumer">

                    {{--Username Field--}}
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="control-label">Username <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">@</span>
                            <input type="text" name="username" class="form-control"
                                   value="{{ $user->username or old('username') }}">
                        </div>
                        @if($errors->has('username'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Username Field--}}
                </div>

                <div class="col-md-4 col-sm-12">
                    {{--Email Field--}}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $user->email or old('email') }}">
                        </div>
                        @if($errors->has('email'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Email Field--}}
                </div>

                <div class="col-md-4 col-sm-12">
                    {{--Password Field--}}
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="help-block with-errors">
                            @if($isEdit)
                                <p class="text-muted font-12">Leave empty if you don't wish to change password.</p>
                            @endif
                            @if($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>

                    </div>
                    {{--End of Password Field--}}
                </div>

                <div class="col-xs-12">
                    <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                        <label class="col-xs-12 control-label">Profile picture</label>
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
                            <div class="help-block with-errors">
                                @if($isEdit)
                                    <p class="text-muted font-12">Leave empty if you don't wish to change avatar.</p>
                                @endif
                                @if($errors->has('avatar'))
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title m-b-0">Personal Details</h3>
            <p class="text-muted m-b-30">Enter user's personal information</p>
            <div class="row">
                <div class="col-xs-12">

                    {{--First Name Field--}}
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="control-label">First Name <span
                                    class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control"
                               value="{{ $user->first_name or old('first_name') }}">
                        @if($errors->has('first_name'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of First Name Field--}}

                    {{--Last Name Field--}}
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="control-label">Last Name <span
                                    class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control"
                               value="{{ $user->last_name or old('last_name') }}">
                        @if($errors->has('last_name'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Last Name Field--}}

                    {{--Gender Field--}}
                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <div class="radio-list">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="gender" value="1"
                                           id="male" {{ $isEdit ? ($user->gender == 1 ? 'checked' : '') : 'checked' }}>
                                    <label for="male">Male</label>
                                </div>
                            </label>
                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="gender" value="2"
                                           id="female" {{  (isset($user) && $user->gender == 2) ? 'checked' : '' }}>
                                    <label for="female">Female</label>
                                </div>
                            </label>
                        </div>
                        @if($errors->has('gender'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Gender Field--}}

                    {{--Birth Date Field--}}
                    <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                        <label for="birth_date" class="control-label">Birth Date <span
                                    class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="birth_date" class="form-control mydatepicker"
                                   placeholder="mm/dd/yyyy"
                                   value="{{ isset($user) ? $user->birth_date->format('m/d/Y') : old('birth_date') }}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                        @if($errors->has('birth_date'))
                            <div class="help-block with-errors">
                                <ul class="list-unstyled">
                                    @foreach($errors->get('birth_date') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif

                    </div>
                    {{--End of Birth Date Field--}}

                    {{--Phone Number Field--}}
                    <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label for="phone_number" class="control-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control"
                               value="{{ isset($user) ? $user->getMeta('phone_number') : old('phone_number') }}">
                        @if($errors->has('phone_number'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Phone Number Field--}}

                    {{--Country Field--}}
                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                        <label class="control-label">Country <span class="text-danger">*</span></label>
                        <select name="country" class="form-control">
                            <option>-- Select Country --</option>
                            @foreach($countries as $code => $country)
                                <option value="{{ $code }}"
                                @if($isEdit)
                                    {{ $user->country == $code ? 'selected' : '' }}
                                        @endif
                                >{{ $country }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('country'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('country') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Country Field--}}

                    <div class="form-group">
                        <label for="language">Language <span class="text-danger">*</span></label>
                        <?php $languages = ['ar' => 'Arabic', 'en' => 'English'] ?>
                        <select name="language" id="language" class="form-control">
                            @foreach($languages as $languageCode => $language)
                                <option value="{{ $languageCode }}"
                                @if(isset($user) && $user->$language == $languageCode)
                                    {{ 'selected' }}
                                        @endif
                                >{{ $language }}</option>
                            @endforeach
                        </select>
                    </div>


                    {{--Instagram ID Field--}}
                    <div class="form-group">
                        <label for="instagram_id">Instagram ID</label>
                        <input type="text" name="instagram_id" class="form-control"
                               value="{{ isset($user) ? $user->getMeta('instagram_id') : old('instagram_id') }}">
                    </div>
                    {{--End of Instagram ID Field--}}

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="white-box">
            <h3 class="box-title m-b-0">Health Details</h3>
            <p class="text-muted m-b-30">Enter user's health details</p>
            <div class="row">
                <div class="col-xs-12">

                    <div class="form-group">
                        <label for="blood_type">Blood Type <span class="text-danger">*</span></label>
                        <?php $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] ?>
                        <select name="blood_type" id="blood_type" class="form-control">
                            @foreach($blood_types as $blood_type)
                                <option value="{{ $blood_type }}"
                                @if(isset($user) && $user->getMeta('blood_type') == $blood_type)
                                    {{ 'selected' }}
                                        @endif
                                >{{ $blood_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="white-box">
            <h3 class="box-title m-b-0">Subscription Details</h3>
            <p class="text-muted m-b-30">Enter user's subscription details</p>
            <div class="row">
                <div class="col-xs-12">

                    <input type="hidden" name="status" value="active">
                    {{--Subscription Type Field--}}
                    <div class="form-group">
                        <label for="gender">Subscription Type <span class="text-danger">*</span></label>
                        <div class="radio-list">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="type" value="gold"
                                           id="gold" {{ isset($user->subscription->type, $isEdit) ? ($user->subscription->type == 'gold' ? 'checked' : '') : 'checked'  }}>
                                    <label for="gold">GOLD</label>
                                </div>
                            </label>
                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="type" value="platinum"
                                           id="platinum" {{  isset($isEdit , $user->subscription->type) ? ($user->subscription->type == 'platinum' ? 'checked' : ''):'' }}>
                                    <label for="platinum">PLATINUM</label>
                                </div>
                            </label>
                        </div>
                    </div>
                    {{--End of Subscription Type Field--}}


                    {{--Subscription Date Range Field--}}
                    <div class="form-group">
                        <label>Subscription Date Range <span class="text-danger">*</span></label>
                        <div class="input-daterange input-group" id="date-range">
                            <input type="text" name="start_date" class="form-control"
                                   value="{{ isset($user,$user->subscription) ? $user->subscription->start_date->format('m/d/Y') : old('start_date') }}">
                            <span class="input-group-addon bg-info b-0 text-white">to</span>
                            <input type="text" name="expiry_date" class="form-control"
                                   value="{{ isset($user,$user->subscription) ? $user->subscription->expiry_date->format('m/d/Y') : old('expiry_date') }}">
                        </div>
                    </div>
                    {{--End of Subscription Date Range Field--}}

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="white-box">
                    <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                </div>

            </div>
        </div>

    </div>
</div>