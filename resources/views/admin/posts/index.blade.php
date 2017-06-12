@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            {{ studly_case($postType) }}
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
                <h3 class="box-title m-b-15">{{ $postType }} list</h3>
                <div class="row m-b-15">
                    <div class="col-sm-6">
                        <a href="{{ route('posts', ['postType' => $postType]) }}">published</a>
                        <span> | </span>
                        <a href="?status=pending">pending ({{ $pendingCount }})</a>
                    </div>
                    <div class="col-sm-6">
                        <div class="table-search pull-right">
                            <form action="{{ route('posts', ['postType' => $postType]) }}">
                                <label for="search">Search: </label>
                                <input type="text" name="search" placeholder="Type + Enter ...">
                            </form>
                        </div>
                    </div>
                </div>
                <form action="{{ route('batchAction') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row m-b-15">
                        <div class="col-sm-6">
                            <label for="action">Action: </label>
                            <select name="action" id="action">
                                <option value="delete">Delete</option>
                                @if($currentUser->isAdmin)
                                    @if($status == 'publish')
                                        <option value="pending">Pending</option>
                                    @elseif($status == 'pending')
                                        <option value="publish">publish</option>
                                    @endif
                                @endif
                            </select>
                            <button type="submit" class="btn btn-sm btn-info">Act</button>
                        </div>
                        <div class="col-sm-6">
                            <div class="links pull-right">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-info">
                                        <input type="checkbox" class="selectAll">
                                        <label></label>
                                    </div>
                                </th>
                                <th>Title</th>
                                @if($postType == 'companies')
                                <th>Address</th>
                                <th>Website</th>
                                @endif
                                <th>Excerpt</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    {{--<td>{{ $post->id }}</td>--}}
                                    <td>
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" name="batch_ids[]"
                                                   class="batchIds"
                                                   value="{{ $post->id }}" id="post-{{ $post->id }}">
                                            <label for="post-{{ $post->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    @if($postType == 'companies')
                                    <td>{{ $post->getMeta('address') }}</td>
                                    <td>
                                        @if(!empty($post->getMeta('website')))
                                        <a href="http://{{ $post->getMeta('website') }}" target="_blank">
                                        {{ $post->getMeta('website') }}
                                        </a>
                                        @endif
                                    </td>
                                    @endif
                                    <td>{{ str_limit($post->excerpt, 50)  }}</td>
                                    <td>
                                        <a href="{{ route('profile', ['user' => $post->writer->id]) }}">{{ $post->writer->username }}</a>
                                    </td>
                                    <td>{{ $post->created_at->toFormattedDateString() }}</td>
                                    <td class="actions">
                                        <a href="{{ route('editPost', ['postType' => $postType, 'post' => $post->id]) }}"
                                           class="btn btn-outline btn-primary"><i class="fa fa-pencil"></i></a>
                                        
                                        <!-- Change Status -->
                                        @if($currentUser->isAdmin)
                                            @if($status == 'publish')
                                                <a href="{{ route('statusPost', ['postType' => $postType, 'post' => $post->id]) }}"
                                           class="btn btn-outline btn-warning"><i class="fa fa-lock"></i>
                                           </a>
                                            @elseif($status == 'pending')
                                                <a href="{{ route('statusPost', ['postType' => $postType, 'post' => $post->id]) }}"
                                           class="btn btn-outline btn-info"><i class="fa fa-globe"></i></a>
                                            @endif
                                        @endif
                                        <button type="button" class="deleteButton btn btn-outline btn-danger"
                                                data-toggle="modal"
                                                data-target="#delete-modal"
                                                data-route="{{ route('deletePost', ['postType' => $postType, 'post' => $post->id]) }}">
                                            <i
                                                    class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <form action="" id="delete-form" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Are you sure you want to delete this post?</h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger" id="add-section">Yes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{--<div class="row">--}}
    {{--@foreach($posts as $post)--}}
    {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
    {{--<div class="white-box">--}}
    {{--<div class="text-muted">--}}
    {{--<span class="m-r-20">{{ $post->created_at->toFormattedDateString() }}</span>--}}
    {{--<span><i class="fa fa-user"></i> <a href="{{ route('profile', ['user' => $post->writer->id]) }}">{{ '@' . $post->writer->username }}</a></span>--}}
    {{--</div>--}}
    {{--<h3 class="m-b-20 m-t-20">{{ $post->title }}</h3>--}}
    {{--<p>{{ str_limit($post->excerpt, 50) }}</p>--}}
    {{--<div class="posts-action-buttons m-t-20">--}}
    {{--<a href="{{ route('editPost', ['postType' => $postType, 'post' => $post->id]) }}" class="btn btn-outline btn-primary"><i class="fa fa-pencil"></i> Edit</a>--}}
    {{--<button type="button" onclick="document.getElementById('{{ 'deletePost' . $post->id }}').submit()" class="btn btn-outline btn-danger"><i class="fa fa-trash"></i> Delete</button>--}}
    {{--<form action="{{ route('deletePost', ['postType' => $postType, 'post' => $post->id]) }}" method="POST" class="hidden" id="deletePost{{ $post->id }}">--}}
    {{--{{ method_field('delete') }}--}}
    {{--{{ csrf_field() }}--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--</div>--}}
@endsection


@section('scripts')
    <script>
        var deleteForm = document.getElementById('delete-form');
        var deleteButtons = document.querySelectorAll('.deleteButton');
        var selectAll = document.querySelector('.selectAll');
        var batchIds = document.querySelectorAll('.batchIds');
        var isAllSelected = false;
        for (var deleteButton of deleteButtons) {
            deleteButton.addEventListener('click', function () {
                var route = this.getAttribute('data-route');
                deleteForm.setAttribute('action', route);
            });
        }
         $('.selectAll').on('click', function() {
            if(this.checked) {
                    $(':checkbox').each(function() {
                        this.checked = true;
                    });
            }
            else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                    });
            }
    });
    </script>
@endsection