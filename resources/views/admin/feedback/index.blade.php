@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            User Feedback
        </h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-15">Feedback</h3>
                <form action="{{ route('feedbackBatchAction') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row m-b-15">
                        <div class="col-sm-6">
                            <label for="action">Action: </label>
                            <select name="action" id="action">
                                <option value="delete">Delete</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-info">Act</button>
                        </div>
                        <div class="col-sm-6">
                            <div class="links pull-right">
                                {{ $feedback->links() }}
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
                                <th>User</th>
                                <th>Content</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($feedback as $f)
                                <tr>
                                    {{--<td>{{ $post->id }}</td>--}}
                                    <td>
                                        <div class="checkbox checkbox-info">
                                            <input type="checkbox" name="batch_ids[]"
                                                   class="batchIds"
                                                   value="{{ $f->id }}" id="feedback-{{ $f->id }}">
                                            <label for="feedback-{{ $f->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('profile', ['user' => $f->user->id])  }}">{{ $f->user->username }}</a>
                                    </td>
                                    <td>{{ $f->body, 250 }}</td>
                                    <td><span class="label label-danger">{{ $f->type }}</span></td>
                                    <td>{{ $f->created_at->toFormattedDateString() }}</td>
                                    <td class="actions">
                                        <button type="button" class="deleteButton btn btn-outline btn-danger"
                                                data-toggle="modal"
                                                data-target="#delete-modal"
                                                data-route="{{ route('singleFeedback', ['feedback' => $f->id]) }}">
                                            <i class="fa fa-trash"></i>
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
                                <h4>Are you sure you want to delete this feedback?</h4>
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