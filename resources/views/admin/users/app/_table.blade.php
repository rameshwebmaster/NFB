<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th>Name</th>
            <th>Username</th>
            <th>Age</th>
            <th>Gender</th>
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
                <td>{{ $user->birth_date->diffInYears(\Carbon\Carbon::now()) }}</td>
                <td><span class="label label-primary">{{ $user->gender == 1 ? "Male" : "Female" }}</span></td>
                <td>
                    @if($currentUser->isAdmin)
                        <a href="{{ route('profile', ['user' => $user->id]) }}"
                           class="btn btn-outline btn-sm btn-info"><i class="fa fa-user"></i></a>
                    @endif
                    @if($currentUser->isDoctor || $currentUser->isAdmin)
                        <a href="{{ route('userHealthStatus', ['user' => $user->id]) }}"
                           class="btn btn-outline btn-sm btn-success"><i
                                    class="fa fa-line-chart"></i></a>
                    @endif
                    @if($currentUser->isAdmin)
                        <a href="{{ route('editUser', ['user' => $user->id]) }}"
                           class="btn btn-sm btn-outline btn-primary"><i class="fa fa-pencil"></i></a>
                        <button type="button" class="btn btn-outline btn-danger btn-sm btn-delete" data-form="{{ 'deleteUser' . $user->id }}">
                            <i class="fa fa-trash"></i></button>
                        <form class="hidden" action="{{ route('profile', ['user' => $user->id]) }}"
                              method="post" id="{{ 'deleteUser' . $user->id }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                        </form>
                    @endif
                </td>
            </tr>
          @php $i++ @endphp
        @endforeach
        </tbody>
    </table>
</div>