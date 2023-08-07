<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductPage(){

        return view('pages.dashboard.product-page');
    }


    //Create Product

    function createProduct(Request $request){

        $user_id = $request->header('id');

        $img = $request->file('img');

        $t = time(); //For timestamp because of specific user history of add product time
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}--{$t}--{$file_name}"; //Here i concat all the things. User_id+time+file_name

        $img_url = "upoload/{$img_name}";

        //Upload File
        $img->move(public_path('uploads'), $img_url);


        //Save to Database
        return Product::create([

            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $img_url,
            'category_id' => $request->input('category_id'),
            'user_id' => $user_id,

        ]);
        
    }


    function DeleteProduct(Request $request){

        $user_id = $request->header('id');
        
        $product_id = $request->input('id');
        $filePath = $request->input('file_path');
        File::delete('$filePath');
        return Product::where('id', $product_id)->where('user_id', $user_id)->delete();

    }

    function ProductList(Request $request){

        $user_id = $request->header('id');
        return Product::where('user_id',$user_id)->get();

    }


    function ProductUpdate(Request $request){

        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img')){

            //Same image upload method as like as createProduct 

        $img = $request->file('img');

        $t = time(); //For timestamp because of specific user history of add product time
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}--{$t}--{$file_name}"; //Here i concat all the things. User_id+time+file_name

        $img_url = "upoload/{$img_name}";

        //Upload File
        $img->move(public_path('uploads'), $img_url);

        //Delete old File
        $filePath = $request->input('file_path');
        File::delete($filePath);


        return Product::where('id', $product_id)->where('user_id', $user_id)->update([

            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $img_url,
            'category_id' => $request->input('category_id')
           


        ]);



        }else{

            return Product::where('product_id',$product_id)->where('user_id',$user_id)->update([

                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
              
                'category_id' => $request->input('category_id')


            ]);
        }

        

    }



}
