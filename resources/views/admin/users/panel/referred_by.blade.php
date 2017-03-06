@extends('layouts.admin')

@section('styles')
    <style>
        .user-avatar {
            width: 48px;
            height: 48px;
        }
    </style>
@endsection

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Referred Users
        </h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">User list</h3>
                @include('admin.users.app._table')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="center-block">
                {{ $users->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection