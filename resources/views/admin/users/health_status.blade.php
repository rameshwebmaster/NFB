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
            User Health Status
        </h4>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <h3 class="box-title b-m-20">Health Charts</h3>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button">
                        {{ studly_case(request()->get('measure') ?? 'weight') }}
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="?measure=Weight">Weight</a></li>
                        <li><a href="?measure=height">Height</a></li>
                        <li><a href="?measure=shoulder_width">Shoulder Width</a></li>
                        <li><a href="?measure=chest_circumference">Chest Circumference</a></li>
                        <li><a href="?measure=middle_circumference">Middle Circumference</a></li>
                        <li><a href="?measure=arm_circumference">Arm Circumference</a></li>
                        <li><a href="?measure=hip_circumference">Hip Circumference</a></li>
                    </ul>
                </div>
                {!! $measureChart->render() !!}
            </div>
        </div>
    </div>

@endsection