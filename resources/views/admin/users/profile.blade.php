@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            User's profile
        </h4>
    </div>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <div class="user-bg">
                    <img src="/images/profile-bg.jpg" width="100%" alt="profile background">
                    <div class="overlay-box">
                        <div class="user-content">
                            <a href="javascript:void(0)"><img src="/uploads/avatars/{{ isset($user->avatar) ? $user->avatar : 'default.jpg' }}"
                                                              class="thumb-lg img-circle" alt=""></a> <?php //{{ $user->avatar ?? 'default.jpg'}} ?>
                            <h4 class="text-white">{{ '@' }}{{ $user->username }}</h4>
                        </div>
                    </div>
                </div>
                <div class="user-btm-box">
                    <div class="col-md-1 col-sm-4 text-center m-b-20"><p class="text-primary">
                            Age</p>{{ isset($user->birth_date) ? $user->birth_date->diffInYears(\Carbon\Carbon::now()) : 'N/A' }}
                    </div>
                    <div class="col-md-1 col-sm-4 text-center m-b-20"><p class="text-danger">Role</p>{{ $user->role }}</div>
                    <div class="col-md-1 col-sm-4 text-center m-b-20"><p class="text-info">
                            Country</p>{{ $user->country['country_name'] or 'N/A' }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Mobile Number</p>{{ $user->getMeta('phone_number') }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Instagram ID</p>{{ $user->getMeta('instagram_id') }}</div>
                    <div class="col-md-1 col-sm-4 text-center"><p class="text-info">
                            Subscription</p>{{ $user->subscription->type or '' }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Doctor</p><span>Dr. Abdullah Al-Mutawa</span></div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Trainer</p><span>Viktoriia Dudko</span></div>                
                </div>
            </div>
        </div>
        <!-- {{--<div class="col-md-8 col-xs-12">--}}
            {{--<div class="white-box">--}}
                {{--<ul class="nav nav-tabs tabs customtab">--}}
                    {{--<li class="tab active"><a href="#activities" data-toggle="tab">Activities</a></li>--}}
                    {{--<li class="tab"><a href="#messages" data-toggle="tab">Messages</a></li>--}}
                {{--</ul>--}}
                {{--<div class="tab-content">--}}
                    {{--<div class="tab-pane active" id="activities">--}}
                        {{--<ul class="common-list">--}}
                            {{--@foreach($user->activities as $activity)--}}
                                {{--<li><i class="fa fa-circle-o text-info"></i> {{ $activity->description }}</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane" id="messages">--}}
                        {{--<ul class="common-list">--}}
                            {{--@foreach($user->messages as $message)--}}
                                {{--<li><i class="fa fa-circle-o text-info"></i> {{ $message->subject }} sent--}}
                                    {{--at {{ $message->pivot->sent_at }}</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}} -->

    <form action="{{ route('sendUserNotification',['user' => $user->id]) }}" method="post">
              {{ csrf_field() }}
        <div class="col-md-8 col-xs-12">
            
             <h4 class="page-title">
            Send Push Notification
        </h4>

            <div class="white-box m-b-30">
                    <h3 class="box-title m-b-0">English Details</h3>
                    <p class="text-muted m-b-30">Please enter required details in English</p>

                    {{--Subject Field--}}
                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label for="subject" class="control-label">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                        @if($errors->has('subject'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Subject Field--}}


                    {{--Body Field--}}
                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                        <label for="body" class="control-label">Body</label>
                        <textarea name="body" id="body" placeholder="Enter the body"
                                  class="form-control"
                                  style="height: 100px;"></textarea>
                        @if($errors->has('body'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Body Field--}}
                
                    <h3 class="box-title m-b-0">Arabic Details</h3>
                    <p class="text-muted m-b-30">Please enter required details in Arabic</p>

                    {{--Arabic Subject Field--}}
                    <div class="form-group{{ $errors->has('arabic_subject') ? ' has-error' : '' }}">
                        <label for="arabic_subject" class="control-label">Subject</label>
                        <input type="text" name="arabic_subject" id="arabic_subject" class="form-control input-rtl" placeholder="Enter subject">
                        @if($errors->has('arabic_subject'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_subject') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Subject Field--}}


                    {{--Arabic Body Field--}}
                    <div class="form-group{{ $errors->has('arabic_body') ? ' has-error' : '' }}">
                        <label for="arabic_body" class="control-label">Body</label>
                        <textarea name="arabic_body" id="arabic_body" placeholder="Enter the body"
                                  class="form-control input-rtl"
                                  style="height: 100px;"></textarea>
                        @if($errors->has('arabic_body'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_body') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Body Field--}}
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-block btn-success">Send</button>
                    </div>
                </div>
            </div>
            

    </form>
    </div>

@endsection
