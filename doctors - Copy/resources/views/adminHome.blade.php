@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <h1>Wlcome To Doctor Service Management System.</h1>
                    You are Admin, Please check Your Website for more information.
                    <a class="btn btn-success" href="{{ route('admin.index') }}">Click Here<a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection