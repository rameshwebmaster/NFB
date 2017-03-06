@extends('layouts.app')

@section('content')
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>401</h1>
                <h3 class="text-uppercase">Unauthorized Access!</h3>
                <p class="text-muted m-t-30 m-b-30">You don't have enough privilidges to access this page.</p>
                <a href="/nfb-admin" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to dashboard</a>
            </div>
        </div>
    </section>

@endsection