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
                            <a href="javascript:void(0)"><img src="/uploads/avatars/{{ $user->avatar ?? 'default.jpg'}}"
                                                              class="thumb-lg img-circle" alt=""></a>
                            <h4 class="text-white">{{ '@' }}{{ $user->username }}</h4>
                        </div>
                    </div>
                </div>
                <div class="user-btm-box">
                    <div class="col-md-2 col-sm-4 text-center m-b-20"><p class="text-primary">
                            Age</p>{{ isset($user->birth_date) ? $user->birth_date->diffInYears(\Carbon\Carbon::now()) : 'N/A' }}
                    </div>
                    <div class="col-md-2 col-sm-4 text-center m-b-20"><p class="text-danger">Role</p>{{ $user->role }}</div>
                    <div class="col-md-2 col-sm-4 text-center m-b-20"><p class="text-info">
                            Country</p>{{ $user->country['country_name'] or 'N/A' }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Mobile Number</p>{{ $user->getMeta('phone_number') }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Instagram ID</p>{{ $user->getMeta('instagram_id') }}</div>
                    <div class="col-md-2 col-sm-4 text-center"><p class="text-info">
                            Subscription</p>{{ $user->subscription->type or '' }}</div>
                </div>
            </div>
        </div>
        {{--<div class="col-md-8 col-xs-12">--}}
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
        {{--</div>--}}
    </div>

@endsection
