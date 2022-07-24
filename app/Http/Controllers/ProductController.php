<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    $create_date = $request->create_date;
    $search_text =$request->keyword;
    $data['keyword'] = $search_text;
    $data['create_date'] = $create_date;
    if ($create_date == null || $create_date == '') {
        $create_date = '';
    }
    $post_query = Products::select('id','product_name','price','image','created_at');

    if($search_text  != "" && $search_text  != null){
       $post_query->where(function ($query) use ($search_text) {
            if ($search_text != "" && $search_text != null) {
                $query->where('product_name', 'LIKE', '%' . $search_text . '%');
                $data['keyword'] = $search_text;
            }
        });
    }
    if($create_date != ''){
       $post_query->where(function ($query) use ($create_date) {
            if ($create_date != "" && $create_date != null) {
                $query->where('created_at', '>=', $create_date . " 00:00:00");
                $query->where('created_at', '<', $create_date . " 23:59:59");
                $data['create_date'] = $create_date;
            }
         });
    }
    $data['product']=$post_query->orderBy('id','DESC')->paginate(10);
    return view('product.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data['productr'] = '';
       return view('product.create',$data);
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
         "product_name" => ['required','unique:products,product_name', 'nullable'],
         'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
         'image'=>'mimes:jpeg,jpg,png'
        ]);
        $image_name = '';
        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=time().'.'.$image->extension();
            $image->move(public_path('post_images'),$image_name);
        }
        $post=Products::create([
         'product_name'=>$request->product_name,
         'price'=>$request->price,
         'image'=>$image_name,
        ]);

        return redirect()->route('product.index')->with('success','Product successfully created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['product']=Products::findOrFail($id);
        return view('product.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data['product']=Products::findOrFail($id);
       return view('product.edit',$data);
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

        $post=Products::findOrFail($id);

        $request->validate([
            "product_name" => ['required',\Illuminate\Validation\Rule::unique('products')->ignore($id), 'nullable'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'image'=>'mimes:jpeg,jpg,png'
           ]);
           if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=time().'.'.$image->extension();
            $image->move(public_path('post_images'),$image_name);
            $old_path=public_path().'post_images/'.$post->image;

            if(\File::exists($old_path)){
             \File::delete($old_path);
            }

        }else{
           $image_name =$post->image;
        }
        $post->update([
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'image'=>$image_name,
        ]);
        return redirect()->route('product.index')->with('success','Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $post=Products::findOrFail($id);
         $post->delete();
        return redirect()->route('product.index')->with('success','Product successfully deleted.');
    }
}
