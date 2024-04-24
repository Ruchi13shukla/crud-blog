<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
  public function index(){
     return view('products.index',['products'=> Product::latest()->paginate(3)]);
}

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){

        //validate data
        $request->validate([
           'name' =>'required',
           'description' =>'required',
           'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000'

        ]);

       //upload image
       //  dd($request->all());
         $imageName = time(). '.' .$request->image->extension();
         $request->image->move(public_path('products'), $imageName);

         $product = new Product;
         $product->image = $imageName;
         $product->name = $request->name;
         $product->description = $request->description;

         $product->save();

         return back()->withSuccess('Product Created !!');

       }

       public function edit($id){
        // dd($id);
        $product = Product::where('id',$id)->first();
        return view('products.edit',['product' => $product]);
    }  
    
    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required',
            'description' =>'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'

         ]);

        $product = Product::where('id',$id)->first(); 
         
        if(isset($request->image)){
            //upload image
            $imageName = time(). '.' .$request->image->extension();
            $request->image->move(public_path('products'), $imageName);
            $product->image = $imageName;
        } 
        //  dd($request->all());
      
          $product->name = $request->name;
          $product->description = $request->description;

          $product->save();

          return back()->withSuccess('Product Updated !!');
    }


    public function destroy($id){
        $product = Product::where('id',$id)->first();
        $product ->delete();

        return back()->withSuccess('Product Deleted !!');
    }

    public function show($id){
      $product = Product::where('id',$id)->first();
      
      return view('products.show',['product'=>$product]);
  }
 
  public function loadMore(Request $request)
    {
        // Retrieve the page number from the request
        $page = $request->input('page');

        // Fetching employees for the requested page from the database
        $product = Product::paginate(10, ['*'], 'page', $page); // Pagination with 10 records per page

        return response()->json(['product' => $product]);
    }

}
