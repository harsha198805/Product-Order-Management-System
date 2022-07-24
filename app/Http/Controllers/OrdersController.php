<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Products;
use App\Customer;
use App\SaleOrderDetails;
use App\SaleOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $order_date = $request->order_date;
        $search_text = $request->keyword;
        $customer_id = $request->customer_id;
        $data['keyword'] = $search_text;
        $data['order_date'] = $order_date;
        $data['customer_id'] = $customer_id;
        if ($order_date == null || $order_date == '') {
            $order_date = '';
        }
        $post_query = SaleOrder::with(['customer'])->select('id', 'customer_id', 'order_date', 'created_at');
        $post_query->when($search_text, function ($query,  $search_text) {
            if ($search_text  != "" && $search_text  != null) {
                $query->whereHas('customer', function ($query) use ($search_text) {
                    $query->where('customers.fname', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('customers.lname', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('customers.email', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('customers.phone', 'LIKE', '%' . $search_text . '%');
                    $data['keyword'] = $search_text;
                });
            }
        });
        if ($order_date != '') {
            $post_query->where(function ($query) use ($order_date) {
                if ($order_date != "" && $order_date != null) {
                    $query->where('created_at', '>=', $order_date . " 00:00:00");
                    $query->where('created_at', '<', $order_date . " 23:59:59");
                    $data['order_date'] = $order_date;
                }
            });
        }
        $data['sale_order'] = $post_query->orderBy('id', 'DESC')->paginate(10);
        return view('orders.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $data['product'] = Products::orderBy('id', 'desc')->get();

        $customer_id =  $id;
        $customer_data = Customer::where('id', $customer_id)->first();
        if ($customer_data !== null) {
            $customer_name = $customer_data->fname . ' ' . $customer_data->lname;
            $data['customer_id'] =  $customer_id;
            $data['customer_name'] =  $customer_name;
            $data['email'] = $customer_data->email;
            $data['phone'] = $customer_data->phone;
        }
        return view('orders.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'sale_order.*.name' => 'required',
            'sale_order.*.qty' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $dt = Carbon::now();
            SaleOrder::create([
                'customer_id' => $request->customer_id,
                'order_date' => $dt->toDateString()
            ]);
            $lastRecord = SaleOrder::latest()->first();
            $order_id = $lastRecord->id;

            foreach ($request->sale_order as $key => $value) {
                $product_data = Products::where('id', $value['name'])->first();
                $product_price = $product_data->price;
                SaleOrderDetails::create([
                    'order_id' => $order_id,
                    'product_id' => $value['name'],
                    'qty' => $value['qty'],
                    'price' => $product_price,
                ]);
            }
            DB::commit();
            return redirect()->route('order.index')->with('success', 'Sale Order created successfully.');
        } catch (\Exception $ex) {
            DB::rollback();
            // throw $ex;
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['sale_order'] = SaleOrder::with(['customer', 'items'])->where('id', $id)->get();
        $data['product'] = Products::orderBy('id', 'desc')->get();
        //dd($data['sale_order']);
        return view('orders.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['sale_order'] = SaleOrder::findOrFail($id);
        return view('order.edit', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function item_update(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_qty = $request->input('item_qty');

        try {
            $item_order = SaleOrderDetails::find($item_id);
            if ($item_order) {
                $item_order->qty = $item_qty;
                $item_order->update();
            }
            $response['success'] = 1;
            $response['message'] = "Order item QTY updated successfully";
            return $response;
        } catch (\Exception $ex) {
            return false;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function item_add(Request $request)
    {
        $sale_order_product_id = $request->input('sale_order_name');
        $sale_order_qty = $request->input('sale_order_qty');
        $order_id = $request->input('order_id');

        try {

            $product_data = Products::where('id', $sale_order_product_id)->first();
            $product_price = $product_data->price;

            SaleOrderDetails::create([
                'order_id' => $order_id,
                'product_id' => $sale_order_product_id,
                'qty' => $sale_order_qty,
                'price' => $product_price,
            ]);
            $response['success'] = 1;
            $response['message'] = "Order item created successfully";
            return $response;
        } catch (\Exception $ex) {
            return false;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = SaleOrder::findOrFail($id);
        $post->delete();
        return redirect()->route('order.index')->with('success', 'Order successfully deleted.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_item($id)
    {
        $post = SaleOrderDetails::findOrFail($id);
        $post->delete();
        return redirect()->back()->with('success', 'Order Item successfully deleted.');
    }
}
