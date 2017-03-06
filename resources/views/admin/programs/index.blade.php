@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Programs
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
                <h3 class="box-title m-b-0">Program list</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Program Title</th>
                            <th>Program Type</th>
                            <th>Program Table</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($programs as $program)
                            <tr>
                                <td>{{ $program->id }}</td>
                                <td><a href="{{ '/programs/' . $program->id . '/edit' }}">{{ $program->title  }}</a>
                                </td>
                                <td>{{ studly_case($program->type)  }}</td>
                                {{--<td><a href="#" class="btn btn-primary">View Table</a></td>--}}
                                <td><a href="{{ route('programTable', ['program' => $program->id]) }}"
                                       class="btn btn-primary">View Table</a></td>
                                <td>
                                    <a href="{{ route('editProgram', ['program' => $program->id]) }}"
                                       class="btn btn-sm btn-outline btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                       onclick="document.getElementById('{{ 'deleteProgram' . $program->id }}').submit()"
                                       class="btn btn-sm btn-outline btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="deleteProgram{{ $program->id }}"
                                          action="{{ route('program', ['program' => $program->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection