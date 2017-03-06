@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Edit App User
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

    <form action="{{ route('updateAppUser', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}
        {{ method_field('patch') }}

        @include('admin.users._app_form')

    </form>

@endsection

@section('scripts')
    <script>
        $('.mydatepicker').datepicker({autoclose: true});
        $('.input-daterange').datepicker({autoclose: true});
    </script>

@endsection