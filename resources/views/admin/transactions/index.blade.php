@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Transactions
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
                <h3 class="box-title m-b-0">Transaction list</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Transaction Type</th>
                            <th>Transaction Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td><span class="label label-{{ $transaction->type == 'expense' ? 'warning' : 'info' }}">{{ $transaction->type  }}</span></td>
                                <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('edittransactions', ['guide' => $transaction->id]) }}"
                                       class="btn btn-info btn-sm btn-outline btn-primary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                       data-form="{{ 'deletetransaction' . $transaction->id }}"
                                       class="btn btn-sm btn-outline btn-danger btn-delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="deletetransaction{{ $transaction->id }}"
                                          action="{{ route('deletetransaction', ['id' => $transaction->id]) }}" method="post">
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