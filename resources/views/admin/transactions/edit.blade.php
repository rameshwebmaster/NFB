@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Edit Transaction
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

 
    <form action="{{ route('transaction', ['id' => $program->id]) }}" method="post">

        {{ csrf_field() }}

        {{ method_field('patch') }}

         @include('admin.transactions._form')

    </form>


@endsection