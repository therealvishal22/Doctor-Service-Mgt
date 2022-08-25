@extends('layouts.app')
@section('content')
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">

    <style type="text/css">
        #headid
        {
            font-weight: bold;
            font-size: 35px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: rgb(188, 78, 122);
        }
       
    </style>
</head>

@if (auth()->user()->is_admin == '1')

<form method="GET" action="{{route('admin.index')}}">
   
    <select id="md" name="filter">
            <option value="">Select</option>
            @foreach($md as $key => $value)
                   <option value="{{$value->id}}" {{!empty($filter) && $filter==$value->id ? ' selected="selected"' : ''}}>{{ $value->services}}</option>
            @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>
@endif 

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <p id="headid">Doctors List</p>
            </div>
           
            @if (auth()->user()->is_admin == '1')
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.create') }}">Create New Doctor</a>
            </div>
            @endif
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-warning" href="{{ route('user.export') }}">Export Excel Data</a>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>@sortablelink('id')</th>
            <th>@sortablelink('name')</th>
            <th>@sortablelink('email')</th>
            <th>@sortablelink('approve')</th>
            <th>@sortablelink('status')</th>
            @if (auth()->user()->is_admin == '1')
            <th>@sortablelink('approve')</th>
            @endif
            <th>@sortablelink('gender')</th>
            <th>@sortablelink('photo')</th>
            <th>@sortablelink('age')</th>            
            <th>@sortablelink('services')</th>
            @if (auth()->user()->is_admin == '1')
            <th>Active Status</th>
            @endif
            <th width="280px">Action</th>
        </tr>
        @if($users->count())
        <tbody id="tbody">
          
        @foreach ($users as $user)
        {{-- {{$user}} --}}
        <tr>        
            <td>{{$user->id }}</td>
            <td>{{ $user->name}}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->approve }}</td>
            <td>{{ $user->status }}</td>
            @if (auth()->user()->is_admin == '1')
            <td> 

                @if(auth()->user()->is_admin == '1' && $user->approve == 'F')
                    <a class="btn btn-primary approve btn-flat sweet_alert.alert" href="{{ route('admin.approve', $user->id) }}">Approve</a>
                @endif 
            </td>
            @endif
            <td>{{ $user->gender }}</td>
            <td><img src="{{ asset('./public/images/' . $user->image) }}" style="height: 80px; width: 120px;"></td>
            <td>{{ $user->age }}</td>
            
            <td>
            @foreach ($user->services as $service)
            {{$service->services }},
            @endforeach
            </td>
            @if(auth()->user()->is_admin == '1')
            <td> <a class="btn btn-success" href="{{ route('admin.active', $user->id) }}">Active</a>
                <a class="btn btn-warning" href="{{ route('admin.inactive', $user->id) }}">Inactive</a>
            </td>
            @endif
            <td>
                @if(auth()->user()->is_admin == '1' || auth()->user()->id == $user->id)   
                    @if (auth()->user()->is_admin == '0' || auth()->user()->id == $user->id)
                    <a class="btn btn-primary" href="{{ route('admin.edit',$user->id) }}">Edit</a>
                    
                    @endif
                    @if (auth()->user()->is_admin == '1')
                    <form method="POST" action="{{ route('admin.destroy', $user->id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>Delete</button>
                    </form>
                    @endif                   
                    </form>
                @endif               
            </td>
        </tr>
        @endforeach
        </tbody>
        @endif
    </table>
    {!! $users->appends(\Request::except('page'))->render() !!}
 </form>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "Once Deleted, You will not able to undo.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function() {

      $('.approve').click(function(e) {

        if (!confirm('Are you sure to Approve this User?')) {

          e.preventDefault();

        }

      });

    });

  </script>
  

@endsection