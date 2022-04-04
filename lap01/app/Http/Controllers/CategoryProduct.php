<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\Imports;
use App\Exports\ExcelExports;
use Excel;
use App\Models\CategoryProductModel;
class CategoryProduct extends Controller
{
    public function add_category_product(){
        return view('admin.category.add_category_product');
    }
    public function all_category_product(){
        $result['data'] = DB::table('tbl_category_product')->get()->toArray();
        return view('admin.category.all_category_product',$result);
    }
    public function save_category_product(Request $request){
        DB::table('tbl_category_product')->insert([
            'category_name'=>$request->category_product_name,
            'category_desc'=>$request->category_product_desc,
            'category_status'=>$request->category_product_status,
        ]);
        return redirect('all-category-product');
    }
    public function delete_category_product(Request $request){
        DB::table('tbl_category_product')->where('category_id', $request->id)->delete();
        return redirect('all-category-product');
    }
    public function showedit_category_product(Request $request){
        $result['info'] = DB::table('tbl_category_product')->where('category_id', $request->id)->get()->toArray();
        return view('admin.category.edit_category_product',$result);
    }
    public function edit_category_product(Request $request){
        DB::table('tbl_category_product')->where('category_id',$request->category_product_id)->update([
            'category_name'=>$request->category_product_name,
            'category_desc'=>$request->category_product_desc,
            'category_status'=>$request->category_product_status,
        ]);
        return redirect('all-category-product');
    }
    //end admin


    public function show_category_home(Request $request){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $result['data_categoryshow']=DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('tbl_product.category_id',$request->id)
            ->get();
        $category_name['data_category_name'] = DB::table('tbl_category_product')->where('category_id',$request->id)->get();
        return view('client.category',$category,$brand)->with($result)->with($category_name);
    }
    public function export_csv(){
        return Excel::download(new ExcelExports , 'category_product.xlsx');
    }
    public function import_csv(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new Imports, $path);
        return back();
    }
}
