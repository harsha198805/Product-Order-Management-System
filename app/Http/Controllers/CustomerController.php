<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $create_date = $request->create_date;
        $search_text = $request->keyword;
        $data['keyword'] = $search_text;
        $data['create_date'] = $create_date;
        if ($create_date == null || $create_date == '') {
            $create_date = '';
        }
        $post_query = Customer::select('id', 'fname', 'lname', 'email', 'phone', 'created_at');

        if ($search_text  != "" && $search_text  != null) {
            $post_query->where(function ($query) use ($search_text) {
                if ($search_text != "" && $search_text != null) {
                    $query->where('fname', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('lname', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search_text . '%');
                    $query->orWhere('phone', 'LIKE', '%' . $search_text . '%');
                    $data['keyword'] = $search_text;
                }
            });
        }
        if ($create_date != '') {
            $post_query->where(function ($query) use ($create_date) {
                if ($create_date != "" && $create_date != null) {
                    $query->where('created_at', '>=', $create_date . " 00:00:00");
                    $query->where('created_at', '<', $create_date . " 23:59:59");
                    $data['create_date'] = $create_date;
                }
            });
        }
        $data['customer'] = $post_query->orderBy('id', 'DESC')->paginate(10);
        return view('customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['customer'] = '';
        return view('customer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            "email" => ['required', 'unique:customers,email', 'email', 'nullable'],
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:customers,phone', 'nullable'],
        ]);

        $post = Customer::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['customer'] = customer::findOrFail($id);
        return view('customer.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['customer'] = customer::findOrFail($id);
        return view('customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $post = Customer::findOrFail($id);

        $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            "email" => ['required', \Illuminate\Validation\Rule::unique('customers')->ignore($id), 'email', 'nullable'],
            'phone' => ['required', 'numeric', 'digits_between:10,12', \Illuminate\Validation\Rule::unique('customers')->ignore($id), 'nullable'],
        ]);

        $post->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return redirect()->route('customer.index')->with('success', 'Customer successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Customer::findOrFail($id);
        $post->delete();
        return redirect()->route('customer.index')->with('success', 'Customer successfully deleted.');
    }
}
