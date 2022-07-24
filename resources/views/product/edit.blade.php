@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">

          <div class="d-flex justify-content-between">
            <div>Edit Product </div>
            <div><a href="{{route('product.index')}}" class="btn btn-success">Back</a></div>
          </div>
        </div>

        <div class="card-body">
          <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="product_name">Product Name :</label>
              <input type="text" value="{{ (old('product_name')) ? old('product_name') : $product->product_name }}" class="form-control" id="product_name" placeholder="Enter Product Name" name="product_name">
              @if($errors->any('product_name'))
              <span class="text-danger"> {{$errors->first('product_name')}}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="price">Product Price :</label>
              <input type="text" value="{{ (old('price')) ? old('price') : $product->price }}" class="form-control" id="price" placeholder="Enter Product Name" name="price">
              @if($errors->any('price'))
              <span class="text-danger"> {{$errors->first('price')}}</span>
              @endif
            </div>
            @if($product->image)
            <div class="form-group">
              <button type="button" data-toggle="collapse" data-target="#demo" class="btn btn-success">View Image</button>
              <div id="demo" class="collapse">
                <img width="200px" height="200px" src="{{asset('post_images/'.$product->image)}}">
              </div>
            </div>
            @endif
            <div class="form-group">
              <label for="image">Image :</label>
              <input type="file" class="form-control " id="image" placeholder="Choose an image" name="image">
              @if($errors->any('image'))
              <span class="text-danger"> {{$errors->first('image')}}</span>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">

</script>
@endsection