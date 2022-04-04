<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function add_product(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('admin.product.add_product',$brand,$category);
    }
    public function save_product(Request $request){
        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();//lấy tên
            $name_image = current(explode('.',$get_name_image));//curren:lấy đầu explode phân tách thành 2
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension(); //lấy đuôi png,jpg,...
            $get_image->move('public/upload/product',$new_image);   //move() là hàm chuyển tới
            DB::table('tbl_product')->insert([
                'product_name'=>$request->product_name,
                'product_desc'=>$request->product_desc,
                'product_status'=>$request->product_status,
                'product_price'=>$request->product_price,
                'product_content'=>$request->product_content,
                'brand_id'=>$request->product_brand,
                'category_id'=>$request->product_category,
                'product_image'=>$new_image,
            ]);
            return redirect('all-product');
        }
        else
            Session()->flash('error','Thêm không hợp lệ vui lòng nhập lại');
            return redirect()->back();
    }
    public function all_product(){
        $result['data'] = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')->get();
        return view('admin.product.all_product',$result);
    }
    public function showedit_product(Request $request){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $result['info'] = DB::table('tbl_product')->where('product_id', $request->id)->get()->toArray();
        return view('admin.product.edit_product',$result,$category)->with('data_brand',$brand);
    }
    public function edit_product(Request $request){
        $get_image = $request->file('product_image');
        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();//lấy tên
            $name_image = current(explode('.', $get_name_image));//curren:lấy đầu explode phân tách thành 2
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //lấy đuôi png,jpg,...
            $get_image->move('public/upload/product', $new_image);   //move() là hàm chuyển tới
            DB::table('tbl_product')->where('product_id', $request->product_id)->update([
                'product_name' => $request->product_name,
                'product_desc' => $request->product_desc,
                'product_status' => $request->product_status,
                'product_price' => $request->product_price,
                'product_content' => $request->product_content,
                'brand_id' => $request->product_brand,
                'category_id' => $request->product_category,
                'product_image' => $new_image,
            ]);
            return redirect('all-product');
        }
    }
    public function delete_product(Request $request){
        DB::table('tbl_product')->where('product_id', $request->id)->delete();
        return redirect('all-product');
    }
    //end admin


    public function details_product(Request $request){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
            ->where('product_id',$request->id)
            ->get();
        foreach($product as $value){
            $category_id = $value->category_id;
        }
        $product_details['data_product_details'] = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
            ->where('tbl_category_product.category_id',$category_id)
            ->whereNotIn('tbl_product.product_id',[$request->id])
            ->get();
        return view('client.details',$category,$brand)->with('data_product',$product)->with($product_details);
    }

}
