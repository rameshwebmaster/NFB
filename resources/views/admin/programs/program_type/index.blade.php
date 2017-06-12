@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Program Type
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
                       <p><b>Program Type list</b></p>
                    </div>
                    <div class="col-sm-8">
                     <p><b>Note:</b>Keep only <b>One</b> Nutrition Program Type Status '<b>Active</b>' at time so Active nutrition data can receive to App users.If both are '<b>Inactive</b>' then NP will not send to the App uses.If both are <b>'Active'</b> then only <b>Regular NP will be fetched.</b></p>
                    </div>
                    <!-- <div class="col-sm-2 col-sm-offset-6">
                    <a class="btn btn-info pull-right m-l-20 btn-outline" href="{{ route('createProgramType', []) }}">Add Program type</a>
                    </div> -->
                </div>
            </div>
            <div class="white-box">
               <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Program Title</th>
                            <th>Description</th>
                            <th>View Programs</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($programs->currentPage() - 1)* $programs->perPage()+1; @endphp
                        @foreach($programs as $program)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><a href="{{ route('editProgramType', ['program' => $program->id]) }}">{{ $program->name  }}</a>
                                </td>
                                <td>{{ $program->description  }}</td>
                                
                                <td><a href="{{ route('showProgramType', ['program' => $program->type_value]) }}"
                                       class="btn btn-info btn-outline">View Program</a>
                                </td>
                                <td>{{ $program->status }}</td>
                                <td>
                                    <a href="{{ route('editProgramType', ['program' => $program->id]) }}"
                                       class="btn btn-info btn-sm btn-outline btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <!-- <a href="javascript:void(0);"
                                       data-form="{{ 'deleteProgramType' . $program->id }}"
                                       class="btn btn-sm btn-outline btn-danger btn-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="deleteProgramType{{ $program->id }}"
                                          action="{{ route('deleteProgramType', ['program' => $program->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>  -->
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
                {{ $programs->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>  
@endsection
