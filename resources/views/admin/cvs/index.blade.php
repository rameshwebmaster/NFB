@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
           CV Guide
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

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-4">
                       <p><b>CV list</b></p>
                    </div>
                    <!-- <div class="col-sm-2 col-sm-offset-6">
                    <a class="btn btn-info pull-right m-l-20 btn-outline" href="{{ route('createCV', []) }}">Add New CV</a>
                    </div> -->
                </div>
            </div>
            <div class="white-box">
               <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Avatar</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($guides->currentPage() - 1)* $guides->perPage()+1; @endphp
                        @foreach($guides as $guide)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><a href="{{ route('editCV', ['program' => $guide->id]) }}">{{ $guide->name  }}</a>
                                </td>
                                <td>{{ $guide->role  }}</td>
                                <td><img style="width: 100px;" class="img-circle user-avatar"
                                    src="/uploads/avatars/{{ (isset($guide->avatar) && !empty($guide->avatar)) ? $guide->avatar : 'default.jpg' }}">
                                </td>
                                <td>
                                    <a href="{{ route('editCV', ['program' => $guide->id]) }}"
                                       class="btn btn-info btn-sm btn-outline btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                       data-form="{{ 'deleteCV' . $guide->id }}"
                                       class="btn btn-sm btn-outline btn-danger btn-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="deleteCV{{ $guide->id }}"
                                          action="{{ route('deleteCV', ['guide' => $guide->id]) }}" method="post">
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
                {{ $guides->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>  
@endsection
