@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>View Product </div>
            <div><a href="{{route('product.index')}}" class="btn btn-success">Back</a></div>
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
                <td>{{$product->id}}</td>
              </tr>

              <tr>
                <td>Product Name</td>
                <td>{{$product->product_name}}</td>
              </tr>

              <tr>
                <td>Product Price</td>
                <td>{{$product->price}}</td>
              </tr>

              <tr>
                <td>Image</td>
                <td>
                  @if($product->image)
                  <img width="100px" height="100px" src="{{asset('post_images/'.$product->image)}}">
                  @endif
                </td>
              </tr>

              <tr>
                <td>Created At</td>
                <td>
                  {{$product->created_at}}
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