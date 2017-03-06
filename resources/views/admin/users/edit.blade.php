@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Edit user
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

    <form action="{{ route('updatePanelUser', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">

        {{ method_field('patch') }}

        @include('admin.users._panel_form')

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <button type="submit" class="btn btn-success btn-block">Update User</button>
            </div>
        </div>
    </form>

@endsection