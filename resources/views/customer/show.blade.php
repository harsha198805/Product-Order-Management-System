@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>View Customer </div>
            <div><a href="{{route('customer.index')}}" class="btn btn-success">Back</a></div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="20%">Field Name</th>
                <th width="80%"> Value</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Id</td>
                <td>{{$customer->id}}</td>
              </tr>

              <tr>
                <td>First Name</td>
                <td>{{$customer->fname}}</td>
              </tr>

              <tr>
                <td>Last Name</td>
                <td>{{$customer->lname}}</td>
              </tr>

              <tr>
                <td>Email</td>
                <td>{{$customer->email}}</td>
              </tr>

              <tr>
                <td>Phone</td>
                <td>{{$customer->phone}}</td>
              </tr>

              <tr>
                <td>Created At</td>
                <td>
                  {{$customer->created_at}}
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection