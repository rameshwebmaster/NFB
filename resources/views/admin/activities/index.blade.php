@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Activity Logs
        </h4>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Activity List</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>IP Address</th>
                            <th>Description</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td><a href="{{ route('profile', ['user' => $activity->user->id]) }}">{{ $activity->user->username }}</a></td>
                                <td>{{ $activity->ip_address }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at->toDayDateTimeString() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection