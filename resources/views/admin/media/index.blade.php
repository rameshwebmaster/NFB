@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Media
        </h4>
    </div>
@endsection

@section('content')

    @include('admin.partials._alerts')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-xs-12">
                        <span>View : </span>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
                                {{ studly_case(str_plural($type)) }}
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="?type=video">Videos</a></li>
                                <li><a href="?type=thumbnail">Thumbnails</a></li>
                                <li><a href="?type=external_youtube">Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Media List</h3>
                <div class="row">
                    @foreach($medium as $media)
                        <div class="col-md-2 col-sm-4 col-xs-6 m-b-5 m-t-5" style="overflow: hidden;">
                            @if($media->type == 'image')
                                <img class="" src="/uploads/{{ $media->path or '' }}" style="height: 200px; width: auto;">
                            @else
                                <img class="img-responsive" src="/uploads/{{ $media->squareSmall->path or '' }}">
                            @endif

                            <div class="actions" style="position:absolute; top: 5px; left: 15px;">
                                <a href="javascript:void(0)" onclick="document.getElementById('deleteMedia{{ $media->id }}').submit()" class="btn btn-danger btn-sm"><i
                                            class="fa fa-trash"></i></a>
                                <form action="{{ route('deleteMedia', ['media' => $media->id]) }}" id="deleteMedia{{ $media->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}

                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            {{ $medium->appends(Request::except('page'))->links() }}
        </div>
    </div>

@endsection