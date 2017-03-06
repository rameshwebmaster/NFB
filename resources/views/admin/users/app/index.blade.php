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
            Users
        </h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-20">Users list</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#filter-modal">
                            Filter Users
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <form action="" class="pull-right">
                            <label for="year">Year </label>
                            <select name="year" id="year">
                                @foreach([2017, 2018, 2019] as $year)
                                    <option value="{{ $year }}"
                                    @if(request()->has('year'))
                                        {{ request()->get('year') == $year ? 'selected' : '' }}
                                            @endif
                                    >{{ $year }}</option>
                                @endforeach
                            </select>
                            </select>
                            <label for="month">Month </label>
                            <select name="month" id="month">
                                @foreach(range(1,12) as $month)
                                    <option value="{{ $month }}"
                                    @if(request()->has('month'))
                                        {{ request()->get('month') == $month ? 'selected' : '' }}
                                        @endif
                                    >{{ $month }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline btn-sm btn-info">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    @include('admin.users.app._filter_modal')
@endsection