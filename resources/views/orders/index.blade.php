@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>Manage Order</div>
            <div><a href="{{route('customer.index')}}" class="btn btn-success">Create Order</a></div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-2">
            <form class="form-horizontal" action="{{ route('order.search') }}" method="post" autocomplete="off">
              @csrf
              <!-- card-body -->
              <div class="form-group row">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-md-12 col-form-label">
                      Order Date
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control" type="text" id="order_date" name="order_date" readonly="" value="{{ $order_date ?? '' }}" placeholder="Order Date">
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-md-12 col-form-label">
                      Keyword
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input class="form-control form-control-md" type="text" name="keyword" placeholder="Search by Name,email, mobile" value="{{$keyword ?? ''}}" maxlength="100">
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
                  <a href="{{ url('order') }}" class="btn btn-info col-12">Reset <i class="fa fa-refresh" aria-hidden="true"></i></a>
                </div>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table style="width: 100%;" class="table table-stripped ">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Order Date</th>
                  <th class="text-center" style="width: 20%;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(count($sale_order))
                @foreach($sale_order as $data)
                <tr>
                  <td>{{$data->id}}</td>
                  <td style="width:15%">{{$data->customer->fname}} {{$data->customer->lname}}</td>
                  <td>{{$data->customer->email}}</td>
                  <td>{{$data->customer->phone}}</td>
                  <td>{{$data->order_date}}</td>
                  <td class="text-center" style="width:30%;">
                    <a href="{{route('order.show',$data->id)}}" class="btn btn-primary">View & Edit</a>
                    <a href="javascript:delete_order('{{route('order.destroy',$data->id)}}')" class="btn btn-danger">Delete</a>
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
            @if(count($sale_order))
            {{$sale_order->appends(Request::query())->links()}}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form id="order_delete_form" method="post" action="">
  @csrf
  @method('DELETE')
</form>


@endsection

@section('javascript')

<script type="text/javascript">
  function delete_order(url) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this order!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $('#order_delete_form').attr('action', url);
          $('#order_delete_form').submit();
        }
      });
  }

  $(function() {
    $('#order_date').daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      minYear: 2015,
      maxYear: 2030,
      //maxDate: moment(),
      locale: {
        separator: ' - ',
        format: 'YYYY-MM-DD'
      },
    }).val('{{$order_date ?? ""}}');
  })
</script>
@endsection