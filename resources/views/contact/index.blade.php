<!-- index.blade.php -->

@extends('master')
@section('content')
  <div class="container">
  <div>
  <a href="{{action('ContactController@import')}}" class="btn btn-warning">Import</a>
  </div>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
		<th>Contact Number</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cruds as $post)
      <tr>
        <td>{{$post['id']}}</td>
        <td>{{$post['full_name']}}</td>
        <td>{{$post['email']}}</td>
		<td>{{$post['contact_number']}}</td>
        <td><a href="{{action('ContactController@edit', $post['id'])}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{action('ContactController@destroy', $post['id'])}}" method="post">
            {{csrf_field()}}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $cruds->links() }}
  </div>
@endsection