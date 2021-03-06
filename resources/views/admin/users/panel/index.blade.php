@extends('layouts.admin')

@section('styles')
    <style>
        .user-avatar {
            width: 48px;
            height: 48px;
        }
        a.active {
            font-weight: bold;
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
                    <div class="col-xs-6">
                        <a {{ $role == 'admin' ? 'class=active':'' }} href="?role=admin">Admin</a>
                        <span> | </span>
                        <a {{ $role == 'doctor' ? 'class=active':'' }} href="?role=doctor">Doctor</a>
                        <span> | </span>
                        <a {{ $role == 'content-manager' ? 'class=active':'' }} href="?role=content-manager">Content Manager</a>
                        <span> | </span>
                        <a {{ $role == 'marketer' ? 'class=active':'' }} href="?role=marketer">Marketer</a>
                        <span> | </span>
                        <a {{ $role == 'seller' ? 'class=active':'' }} href="?role=seller">Seller</a>
                    </div>
                    <div class="col-xs-6">
                        <div class="pull-right">
                            <form action="">
                                <input type="text" placeholder="search + enter ..." name="search">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">User list</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($users->currentPage() - 1)* $users->perPage()+1; @endphp
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><img class="img-circle user-avatar"
                                         src="/uploads/avatars/{{ (isset($user->avatar) && !empty($user->avatar)) ? $user->avatar : 'default.jpg' }}">
                                </td>
                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                <td>{{ $user->username  }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="label label-primary">{{ $user->role }}</span></td>
                                <td>
                                    @if($user->role == 'seller')
                                        <a href="{{ route('referredByUser', ['user' => $user->id]) }}"
                                           class="btn btn-sm btn-outline btn-info"><i class="fa fa-bullhorn"></i></a>
                                    @endif
                                    <a href="{{ route('editUser', ['user' => $user->id]) }}"
                                       class="btn btn-sm btn-outline btn-primary"><i class="fa fa-pencil"></i></a>
                                    <button type="button" class="btn btn-outline btn-danger btn-sm btn-delete"
                                            data-form="{{ 'deleteUser' . $user->id }}">
                                        <i class="fa fa-trash"></i></button>
                                    <form class="hidden" action="{{ route('profile', ['user' => $user->id]) }}"
                                          method="post" id="{{ 'deleteUser' . $user->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </td>
                            </tr>
                          @php $i++ @endphp  
                        @endforeach
                        </tbody>
                    </table>
                </div>
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