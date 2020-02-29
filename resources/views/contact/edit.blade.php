<!-- edit.blade.php -->

@extends('master')
@section('content')
<div class="container">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <form method="post" action="{{action('ContactController@update', $id)}}">
    <div class="form-group row">
      {{csrf_field()}}
       <input name="_method" type="hidden" value="PATCH">
      <label for="lgFormGroupInput" class="col-sm-2 col-form-label col-form-label-lg">Full Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Full Name" name="full_name" value="{{$crud->full_name}}">
      </div>
    </div>
    <div class="form-group row">
      <label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Email" name="email" value="{{$crud->email}}">
      </div>
    </div>
	<div class="form-group row">
      <label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">Contact Number</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Contact Number" name="contact_number" value="{{$crud->contact_number}}">
      </div>
    </div>
	<div class="form-group row">
      <label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">Relation</label>
      <div class="col-sm-10">
	  <select class="form-control chosen-select" name="relation_id[]" multiple tabindex="4">
		 @foreach($results as $result)
      <option value=" {{$result->id}}" @if(in_array($result->id,$arr))selected="selected"@endif >{{$result->full_name}}</option>
    @endforeach
	</select> 
	  </div>
    </div>
    <div class="form-group row">
      <div class="col-md-2"></div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="{{ URL::previous() }}">Go Back</a>
    </div>
  </form>
</div>
@endsection