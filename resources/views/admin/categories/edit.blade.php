@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Edit Category
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

    <form action="{{ route('category', ['category' => $category->id]) }}" method="post">

        {{ csrf_field() }}

        {{ method_field('patch') }}

        @include('admin.categories._form')
    </form>

@endsection