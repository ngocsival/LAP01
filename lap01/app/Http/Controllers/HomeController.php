<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $allproduct['data_product'] = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc')->limit(4)->get();
        return view('client.home',$category,$brand)->with($allproduct);
    }
    public function search(Request $request){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $search_product['search_product'] = DB::table('tbl_product')->where('product_name','like','%'.$request->keywords.'%')->get();
        return view('client.search',$category,$brand)->with($search_product);
    }
}
