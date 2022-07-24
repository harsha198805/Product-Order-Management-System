@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">

        <div class="card card-info">
          <!-- card-header -->
          <div class="card-header">
            <h3 class="card-title">New Salse Order Details</h3>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <div class="col-lg-2 col-md-4  col-xs-12">
                <h5 class="text-center">Customer Name : </h5>
              </div>
              <div class="col-lg-3 font-weight-bold">
                <h5 class="font-weight-bold text-center">{{$customer_name }}</h5>
              </div>
              <div class="col-lg-1 col-md-4  col-xs-12">
                <h5 class="text-center">Email : </h5>
              </div>
              <div class="col-lg-2 font-weight-bold">
                <h5 class="font-weight-bold text-center">{{ $email }}</h5>
              </div>

              <div class="col-lg-2 col-md-4  col-xs-12">
                <h5 class="text-center">Mobile : </h5>
              </div>
              <div class="col-lg-2 font-weight-bold">
                <h5 class="font-weight-bold text-center">{{$phone }}</h5>
              </div>
            </div>
            <form action="{{ route('add_order_form', $customer_id) }}" method="POST">
              @csrf
              <div class="table-responsive">
                <table id="dynamicTable" class="table table-bordered table-striped table-hover">
                  <tr>
                    <th style="width: 40%" class="text-center">Product&nbsp;&nbsp;<span style="color:red;">*</span></th>
                    <th style="width: 30%" class="text-center">Quantity&nbsp;&nbsp;<span style="color:red;">*</span></th>
                    <th style="min-width:200px" class="no-sort text-center">Action</th>
                  </tr>
                  <tr>
                    <td>
                      <select class="form-control" id="product" name="sale_order[0][name]">
                        <option value="">Select Product</option>
                        @if(count($product))
                        @foreach($product as $product_data)
                        <option value="{{$product_data->id}}">{{$product_data->product_name}}</option>
                        @endforeach
                        @endif
                      </select>
                    </td>
                    <td><input type="text" name="sale_order[0][qty]" placeholder="Quantity" maxlength="20" class="form-control" /></td>
                    <td><button type="button" name="add" id="add" class="btn btn-success col-12">Add More</button></td>
                  </tr>
                </table>
              </div>
              <br>
              <hr>
              <div class="row Afixess">
                <div class="col-lg-2 col-md-4 but_pad">
                  <button type="submit" class="btn btn-success col-12" name="save">Save <i class="fa fa-save" aria-hidden="true"></i></button>
                </div>
                <div class="col-lg-2 col-md-4 but_pad">
                  <a href="{{ url('add_order', $customer_id) }}" class="btn btn-warning col-12 ">Reset <i class="fa fa-refresh" aria-hidden="true"></i></a>
                </div>
                <div class="col-lg-2 col-md-4 but_pad">
                  <a href="{{ url('order') }}" class="btn btn-default col-12 but_pad">Back <i class="fa fa-backward" aria-hidden="true"></i></a>
                </div>
              </div>
              <input class="form-control" type="hidden" id="customer_id" name="customer_id" value="{{ $customer_id }}">
            </form>
          </div>
          <div class="card-footer">
          </div>
        </div>
        <div class="card-footer">
        </div>
      </div>
      <script type="text/javascript">
        var i = 0;
        $("#add").click(function() {
          var customer_data = <?php echo $product ?>;
          ++i;
          var options = '<tr><td> <select class="form-control" id="product" name="sale_order[' + i + '][name]">';
          options += '<option value="">Select Product</option>';
          $(customer_data).each(function(index, value) { //loop through your elements
            options += '<option value="' + value.id + '">' + value.product_name + '</option>';
          });
          options += '</select></td><td><input type="text" name="sale_order[' + i + '][qty]" placeholder="Quantity" class="form-control" /></td><td><button type="button" class="btn btn-danger  col-12 remove-tr">Remove</button></td></tr>';
          $('#dynamicTable').append(options);
        });

        $(document).on('click', '.remove-tr', function() {
          $(this).parents('tr').remove();
        });
      </script>
    </div>
  </div>
</div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
</script>
@endsection