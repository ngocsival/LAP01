<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandProduct extends Controller
{
    public function add_brand_product(){
        return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
        $result['data'] = DB::table('tbl_brand_product')->get()->toArray();
        return view('admin.brand.all_brand_product',$result);
    }
    public function save_brand_product(Request $request){
        $this->validate($request,[
            'brand_product_name'=> 'required',
            'brand_product_desc'=> 'required',
            'brand_product_status'=>'required',
        ]);
        Brand::insert([
            'brand_name'=>$request->brand_product_name,
            'brand_desc'=>$request->brand_product_desc,
            'brand_status'=>$request->brand_product_status,
        ]);
        return redirect('all-brand-product');
    }
    public function delete_brand_product(Request $request){
        DB::table('tbl_brand_product')->where('brand_id', $request->id)->delete();
        return redirect('all-brand-product');
    }
    public function showedit_brand_product(Request $request){
        $result['info'] = DB::table('tbl_brand_product')->where('brand_id', $request->id)->get()->toArray();
        return view('admin.brand.edit_brand_product',$result);
    }
    public function edit_brand_product(Request $request){
        DB::table('tbl_brand_product')->where('brand_id',$request->brand_product_id)->update([
            'brand_name'=>$request->brand_product_name,
            'brand_desc'=>$request->brand_product_desc,
            'brand_status'=>$request->brand_product_status,
        ]);
        return redirect('all-brand-product');
    }
    //end admin


    public function show_brand_home(Request $request)
    {
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id', 'desc')->get();
        $result['data_brandshow'] = DB::table('tbl_product')
            ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
            ->where('tbl_product.brand_id', $request->id)
            ->get();
        $brand_name['data_brand_name'] = DB::table('tbl_brand_product')->where('brand_id',$request->id)->get();
        return view('client.brand', $category, $brand)->with($result)->with($brand_name);
    }
}
