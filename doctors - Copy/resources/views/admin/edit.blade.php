@extends('admin.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Doctors Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      
        <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data"  id="EditForm">
            @csrf
            @method('PUT')
        <input type="hidden" name="user_edit_id" value="{{ $user->id }}" />
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group"> 
                    <strong>Email:</strong>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                </div>
            </div>
           
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Photo:</strong>
                    <input type="file" name="image" id="image" value="{{ $user->image }}" class="form-control" placeholder="Photo">
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Gender</strong>:</strong>
                    <input name="gender" value="Male" type="radio" id="gender" {{$user->gender == 'Male' ? 'checked' : '' }} checked> Male
                    <input name="gender" value="Female" type="radio"  id="gender" {{ $user->gender == 'Female' ? 'checked' : '' }} />Female 
                </div>
            </div>
           
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Age Range:</strong>
                    <select id="age" name="age">    
                        <option id="age" {{ $user->age == '18-30' ? 'selected':'' }}>18-30</option>
                        <option id="age" {{ $user->age == '31-40' ? 'selected':'' }}>31-40</option>
                        <option id="age" {{ $user->age == 'Above 40' ? 'selected':'' }}>Above 40</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <br>
                    <strong>Service Type :</strong><br>
                        @foreach ($services as $service)
                        <input type="checkbox" id="services" name="services[]" required
                        value="{{ $service->id }}" {{in_array($service->id,$user_services) ? 'checked' : ''}}  >{{ $service->services }}<br/>
                        @endforeach

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>   
    </form>


    <style>
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
    </style>  
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $("#EditForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 50
                    },
                    gender: {
                        required: true,
                    },
                    
                },
                messages: {
                    name: {
                        required: "User name is required",
                        maxlength: "User name cannot be more than 20 characters"
                    },
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 50 characters",
                    },
                    gender: {
                        required:  "Please select the gender",
                    },
                   

                }
            });
        });
    </script>
@endsection