@extends('layouts.admin')



@section('page-title')
    <div class="col-xs-6">
        <h4 class="page-title">
            Recipe Categories
        </h4>
    </div>
    <div class="col-xs-6">
        <a href="{{ route('createCategory', ['categoryType' => $categoryType]) }}"
           class="btn btn-info pull-right m-l-20 btn-outline">
            Create New
        </a>
    </div>
@endsection



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Category list</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>category title</th>
                            <th>category description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = ($cats->currentPage() - 1)* $cats->perPage()+1; @endphp
                        @foreach($cats as $cat)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $cat->title  }}</td>
                                <td>{{ str_limit($cat->description) }}</td>
                                <td>
                                    <a href="{{ route('editCategory', ['categoryType' => $categoryType, 'category' => $cat->id]) }}"
                                       class="btn btn-sm btn-primary btn-outline"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0);"
                                       data-form="{{ 'deleteCategory' . $cat->id }}"
                                       class="btn btn-sm btn-outline btn-danger btn-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="deleteCategory{{ $cat->id }}"
                                          action="{{ route('category', ['category' => $cat->id]) }}" method="post">
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

@endsection