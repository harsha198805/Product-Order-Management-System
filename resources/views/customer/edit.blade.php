@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">

          <div class="d-flex justify-content-between">
            <div>Edit Customer </div>
            <div><a href="{{route('customer.index')}}" class="btn btn-success">Back</a></div>
          </div>
        </div>

        <div class="card-body">
          <form action="{{route('customer.update',$customer->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="fname">First Name :</label>
              <input type="text" value="{{ (old('fname')) ? old('fname') : $customer->fname }}" class="form-control" id="fname" placeholder="Enter First Name" name="fname">
              @if($errors->any('fname'))
              <span class="text-danger"> {{$errors->first('fname')}}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="lname">Last Name :</label>
              <input type="text" value="{{ (old('lname')) ? old('lname') : $customer->lname }}" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
              @if($errors->any('lname'))
              <span class="text-danger"> {{$errors->first('lname')}}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="email">Email :</label>
              <input type="text" value="{{ (old('email')) ? old('email') : $customer->email }}" class="form-control" id="email" placeholder="Enter Email" name="email">
              @if($errors->any('email'))
              <span class="text-danger"> {{$errors->first('email')}}</span>
              @endif
            </div>
            <div class="form-group">
              <label for="phone">Phone :</label>
              <input type="text" value="{{ (old('phone')) ? old('phone') : $customer->phone }}" class="form-control" id="phone" placeholder="Enter Phone" name="phone">
              @if($errors->any('phone'))
              <span class="text-danger"> {{$errors->first('phone')}}</span>
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