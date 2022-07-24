@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="alert alert-success text-center allert_message" id="allert_message" role="alert">
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>View Sale Order Details </div>
            <div><a href="" class="btn btn-primary" id="add_item">Add Item</a></div>
            <div><a href="{{route('order.index')}}" class="btn btn-success">Back</a></div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <form action="" method="POST" id="add_item_section">
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
                      <select class="form-control" id="sale_order_name" name="sale_order_name">
                        <option value="">Select Product</option>
                        @if(count($product))
                        @foreach($product as $product_data)
                        <option value="{{$product_data->id}}">{{$product_data->product_name}}</option>
                        @endforeach
                        @endif
                      </select>
                    </td>
                    <td><input type="number" id="sale_order_qty" name="sale_order_qty" placeholder="Quantity" maxlength="20" class="form-control" /></td>
                    <td><button type="button" class="btn btn-success col-12" id="save_order_item" name="save">Save <i class="fa fa-save" aria-hidden="true"></i></button></td>
                  </tr>
                </table>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table style="width: 100%;" class="table table-stripped ">
              <thead>
                <tr>
                  <th width="20%">Order Id</th>
                  <th width="20%"> Customer Name</th>
                  <th width="20%"> Email</th>
                  <th width="20%"> Mobile</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sale_order as $order_data)
                <tr data-entry-id="{{ $order_data->id }}">
                  <td>
                    {{ $order_data->id ?? '' }}
                  </td>
                  <td>
                    {{ $order_data->customer->fname ?? '' .' '. $order_data->customer->lname ?? '' }}
                  </td>
                  <td>
                    {{ $order_data->customer->email ?? '' }}
                  </td>
                  <td>
                    {{ $order_data->customer->phone ?? '' }}
                  </td>
                  <td>
                </tr>

              </tbody>
            </table>
          </div>
          <input value="{{ $order_data->id ?? '' }}" class="form-control" type="hidden" id="order_id" name="order_id">
          <div class="table-responsive">
            <table style="width: 100%;" class="table table-stripped ">
              <thead>
                <tr>
                  <th width="20%">Id</th>
                  <th width="20%"> Product Name</th>
                  <th width="10%"> Qty</th>
                  <th width="15%"> Price</th>
                  <th class="text-center" width="35%"> Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $i =1;
                @endphp
                @foreach($order_data->items as $item)
                <tr>
                  <td>
                    {{ $i }}
                    <input value="{{ $item->id }}" class="form-control" type="hidden" id="item_id" placeholder="Enter QTY" name="item_id">
                  </td>
                  <td>
                    {{ $item->product->product_name }}
                  </td>
                  <td>
                    <input value="{{ $item->qty }}" class="form-control" type="number" id="item_qty_{{$item->id}}" placeholder="Enter QTY" name="item_qty">
                    <div class="alert text-center qty_alert" id="qty_alert_{{ $item->id }}"></div>
                  </td>
                  <td>
                    {{ $item->price * $item->qty }}
                  </td>

                  <td class="text-center" style="width:35%;">
                    <button class="btn btn-success" onclick="item_edit('{{$item->id}}')">Update</button>
                    <a href="javascript:delete_order_item('{{route('order_item.destroy',$item->id)}}')" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<form id="delete_order_item" method="post" action="">
  @csrf
  @method('DELETE')
</form>

@endsection
@section('javascript')

<script type="text/javascript">
  $(document).ready(function() {
    $('.qty_alert').hide();
    $('#allert_message').hide();
    $('#add_item_section').hide();
  });

  function delete_order_item(url) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this order item!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $('#delete_order_item').attr('action', url);
          $('#delete_order_item').submit();
        }
      });
  }

  function item_edit(item_val) {
    var item_id = item_val;
    var item_qty = $('#item_qty_' + item_val).val();
    $.ajax({
      url: '/order_item_edit',
      type: 'POST',
      cache: false,
      data: {
        "_token": "{{ csrf_token() }}",
        'item_qty': item_qty,
        'item_id': item_id
      },
      success: function(data, textStatus, jQxhr) {
        $('#qty_alert_' + item_id).show();
        if (data.success == 1) {
          $('#qty_alert_' + item_id).html('data.message');
          $('#qty_alert_' + item_id).text(data.message).css('color', 'green');
        } else {
          $('#qty_alert_' + item_id).text(data.message).css('color', 'red');
        }
        setTimeout(function() {
            $('#qty_alert_' + item_id).hide();
            location.reload();
          },
          3000);
      },
      error: function(jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }


  $(document).on("click", "#save_order_item", function() {
    var sale_order_name = $('#sale_order_name').val();
    var sale_order_qty = $('#sale_order_qty').val();
    var order_id = $('#order_id').val();


    if (sale_order_qty == '') {
      $('#allert_message').show();
      $('#allert_message').text('Product QTY is required').css('color', 'red');
    }
    if (sale_order_name == '') {
      $('#allert_message').show();
      $('#allert_message').text('Product item is required').css('color', 'red');
    }

    if (sale_order_name != '' && sale_order_qty != '') {
      $.ajax({
        url: '/order_item_add',
        type: 'POST',
        cache: false,
        data: {
          "_token": "{{ csrf_token() }}",
          'sale_order_name': sale_order_name,
          'sale_order_qty': sale_order_qty,
          'order_id': order_id,

        },
        success: function(data, textStatus, jQxhr) {
          $('#allert_message').show();
          if (data.success == 1) {
            $('#allert_message').html('data.message');
            $('#allert_message').text(data.message).css('color', 'green');
          } else {
            $('#allert_message').text(data.message).css('color', 'red');
          }
          setTimeout(function() {
              $('#allert_message').hide();
              location.reload();
            },
            3000);
        },
        error: function(jqXhr, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    }
  });
  $('#add_item').click(function(event) {
    $('#add_item_section').show();
    return false;
  });
</script>
@endsection