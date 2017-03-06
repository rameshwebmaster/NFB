@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Send {{ studly_case($messageType) }}
        </h4>
    </div>
@endsection

@section('content')

    <form action="{{ route('message', ['messageType' => $messageType]) }}" method="post">

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-8">

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
                                  style="height: 250px;"></textarea>
                        @if($errors->has('body'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Body Field--}}
                </div>

                <div class="white-box">
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
                                  style="height: 250px;"></textarea>
                        @if($errors->has('arabic_body'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_body') }}</strong>
                            </div>
                        @endif
                    </div>
                    {{--End of Body Field--}}
                </div>


            </div>
            <div class="col-md-4">

                <div class="white-box">
                    <h4 class="box-title m-b-0">To</h4>
                    <p class="text-muted m-b-30">Select users to send</p>
                    @include('admin.partials._filter_user')

                    {{--@if(isset($receivingUser))--}}
                        {{--<span>Send To {{ $receivingUser->username }}</span>--}}
                        {{--<input type="hidden" name="user" value="{{ $receivingUser->id }}">--}}
                    {{--@else--}}

                        {{--<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">--}}
                            {{--<label for="country">Country</label>--}}
                            {{--<select class="form-control" name="country" id="country">--}}
                                {{--<option value="">-- Select a Country --</option>--}}
                                {{--@foreach($countries as $code => $country)--}}
                                    {{--<option value="{{ $code }}">{{ $country }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">--}}
                            {{--<label for="gender">Gender</label>--}}
                            {{--<select class="form-control" name="gender" id="gender">--}}
                                {{--<option value="">-- Select a Gender --</option>--}}
                                {{--<option value="1">Male</option>--}}
                                {{--<option value="2">Female</option>--}}
                            {{--</select>--}}
                            {{--@if($errors->has('gender'))--}}
                                {{--<div class="help-block with-errors">--}}
                                    {{--<strong>{{ $errors->first('gender') }}</strong>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('age_from') ? ' has-error' : '' }}">--}}
                            {{--<label for="age_from">Age From</label>--}}
                            {{--<input type="text" name="age_from" class="form-control">--}}
                            {{--@if($errors->has('age_from'))--}}
                                {{--<div class="help-block with-errors">--}}
                                    {{--<strong>{{ $errors->first('age_from') }}</strong>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('age_to') ? ' has-error' : '' }}">--}}
                            {{--<label for="age_to">Age To</label>--}}
                            {{--<input type="text" name="age_to" class="form-control">--}}
                            {{--@if($errors->has('age_to'))--}}
                                {{--<div class="help-block with-errors">--}}
                                    {{--<strong>{{ $errors->first('age_to') }}</strong>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}

                    {{--@endif--}}

                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-block btn-success">Send</button>
                    </div>
                </div>

            </div>
        </div>

    </form>
@endsection