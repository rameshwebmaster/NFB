@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Transactions
        </h4>
    </div>
@endsection


@section('content')

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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td><span class="label label-{{ $transaction->type == 'expense' ? 'warning' : 'info' }}">{{ $transaction->type  }}</span></td>
                                <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection