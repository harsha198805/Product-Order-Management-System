@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>Manage Products</div>
            <div><a href="{{route('product.create')}}" class="btn btn-success">Create Product</a></div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-2">
            <form class="form-horizontal" action="{{ route('product.search') }}" method="post" autocomplete="off">
              @csrf
              <!-- card-body -->
              <div class="form-group row">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-md-12 col-form-label">
                      Create Date
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control" type="text" id="create_date" name="create_date" readonly="" value="{{ $create_date ?? '' }}" placeholder="Create Date">
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-md-12 col-form-label">
                      Keyword
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control form-control-md" type="text" name="keyword" placeholder="Search by Product Name" value="{{$keyword ?? ''}}" maxlength="100">
                      @if ($errors->has('keyword'))
                      <span class="text-danger">{{ $errors->first('keyword') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-lg-3 button-margin">
                  <button type="submit" class="btn btn-primary col-12" id="search_button" name="search_button">Search <i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                <div class="col-lg-3 button-margin">
                  <a href="{{ url('product') }}" class="btn btn-info col-12">Reset <i class="fa fa-refresh" aria-hidden="true"></i></a>
                </div>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table style="width: 100%;" class="table table-stripped ">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Product Price</th>
                  <th>Image</th>
                  <th>Create Date</th>
                  <th class="text-center" style="width: 20%;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(count($product))
                @foreach($product as $data)
                <tr>
                  <td>{{$data->id}}</td>
                  <td style="width:15%">{{$data->product_name}}</td>
                  <td>{{$data->price}}</td>
                  <td>
                    @if($data->image)
                    <img width="100px" height="100px" src="{{asset('post_images/'.$data->image)}}">
                    @endif
                  </td>
                  <td>{{$data->created_at}}</td>
                  <td class="text-center" style="width:250px;">
                    <a href="{{route('product.show',$data->id)}}" class="btn btn-primary">View</a>
                    <a href="{{route('product.edit',$data->id)}}" class="btn btn-success">Edit</a>
                    <a href="javascript:delete_product('{{route('product.destroy',$data->id)}}')" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="6">
                    <div class="alert alert-danger text-center" role="alert">
                      No records found
                    </div>
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
            @if(count($product))
            {{$product->appends(Request::query())->links()}}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form id="product_delete_form" method="post" action="">
  @csrf
  @method('DELETE')
</form>


@endsection

@section('javascript')

<script type="text/javascript">
  function delete_product(url) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this product!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $('#product_delete_form').attr('action', url);
          $('#product_delete_form').submit();
        }
      });
  }

  $(function() {
    $('#create_date').daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      minYear: 2015,
      maxYear: 2030,
      //maxDate: moment(),
      locale: {
        separator: ' - ',
        format: 'YYYY-MM-DD'
      },
    }).val('{{$create_date ?? ""}}');
  })
</script>
@endsection