@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Dashboard
        </h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row row-in">
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-xs-6">
                                <i class="ti-write"></i>
                                <h5 class="text-muted vb">
                                    @if($currentUser->isAdmin)
                                        <a href="{{ route('posts', ['postType' => 'advices']) }}">Advices</a>
                                    @else
                                        Advices
                                    @endif
                                </h5>
                            </div>
                            <div class="col-xs-6">
                                <h3 class="counter text-right m-t-15 text-danger">{{ \App\Post::where('type', 'advice')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 row-in-br b-r-none">
                        <div class="col-in row">
                            <div class="col-xs-6">
                                <i class="fa fa-user"></i>
                                <h5 class="text-muted vb">
                                    @if($currentUser->isAdmin)
                                        <a href="{{ route('posts', ['postType' => 'exercises']) }}">Exercise</a>
                                    @else
                                        Exercise
                                    @endif
                                </h5>
                            </div>
                            <div class="col-xs-6">
                                <h3 class="counter text-right m-t-15 text-megna">{{ \App\Post::where('type', 'exercise')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 row-in-br">
                        <div class="col-in row">
                            <div class="col-xs-6">
                                <i class="fa fa-user"></i>
                                <h5 class="text-muted vb">
                                    @if($currentUser->isAdmin)
                                        <a href="{{ route('posts', ['postType' => 'companies']) }}">Companies</a>
                                    @else
                                        Companies
                                    @endif
                                </h5>
                            </div>
                            <div class="col-xs-6">
                                <h3 class="counter text-right m-t-15 text-primary">{{ \App\Post::where('type', 'company')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 b-0">
                        <div class="col-in row">
                            <div class="col-xs-6">
                                <i class="fa fa-user"></i>
                                <h5 class="text-muted vb">
                                    @if($currentUser->isAdmin)
                                        <a href="{{ route('posts', ['postType' => 'recipes']) }}">Recipes</a>
                                    @else
                                        Recipes
                                    @endif
                                </h5>
                            </div>
                            <div class="col-xs-6">
                                <h3 class="counter text-right m-t-15 text-success">{{ \App\Post::where('type', 'recipe')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection