@extends('layouts.admin')

@section('styles')
    <style>
        canvas{
            width: 100% !important;
            height: 400px !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Transactions
        </h4>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="white-box">
                {!! $monthlyChart->render() !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="white-box">
                {!! $yearlyChart->render() !!}
            </div>
        </div>
    </div>


@endsection