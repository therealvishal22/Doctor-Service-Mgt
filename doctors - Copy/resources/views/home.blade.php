@extends('layouts.app')

@section('content')
<head>
    <style type="text/css">
        #pid
        {
            font-size: 35px;
            font-weight: bold;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            color: teal;

        }
        .card-body
        {
            background-color: rgb(170, 122, 122);
        }
    </style>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <strong>{{ __('You are logged in!') }}</strong>
                    <p id="pid">Welcome To Doctor Service Management System.</p>
                    <a class="btn btn-success" href="{{ route('admin.index') }}"> Check Activity</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
