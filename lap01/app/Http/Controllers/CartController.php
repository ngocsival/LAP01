<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Session::start();
class CartController extends Controller
{
    public function save_cart(Request $request){
        $data = DB::table('tbl_product')
            ->where('product_id',$request->productid_hidden)
            ->first();
        $data_cart['id'] = $request->productid_hidden;
        $data_cart['qty'] = $request->qty;
        $data_cart['name'] = $data->product_name;
        $data_cart['price'] = $data->product_price;
        $data_cart['weight'] = '123';
        $data_cart['options']['image'] = $data->product_image;
        Cart::add($data_cart);
        Cart::setGlobalTax(10);
        return redirect('show-cart');
    }
    public function show_cart(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('client.cart',$category,$brand);
    }
    public function delete_cart(Request $request){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $rowId = $request->id;
        Cart::remove($rowId);
        return view('client.cart',$category,$brand);
    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart == true){
            $is_avaible = 0;
            foreach ($cart as $key => $value){
                if($value['product_id'] == $data['cart_product_id']){
                    $is_avaible++;
                }
            }
            if($is_avaible == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_price' => $data['cart_product_price'],
                    'product_qty' => $data['cart_product_qty'],
                );
                Session::put('cart',$cart);
            }
        }
        else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            );
            Session::put('cart',$cart);
        }
        Session::save();
    }
    public function gio_hang(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('client.cart_ajax',$category,$brand);
    }
    public function delete_cart_product(Request $request){
        $cart = Session::get('cart');
        if($cart==true){
            foreach ($cart as $key => $value) {
                if ($value['session_id'] == $request->id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back();
        }
    }
    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach ($data['cart_qty'] as $key =>$qty){
                foreach ($cart as $session =>$val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            Session()->flash('success','Cập nhật số lượng thành công');
            return redirect()->back();
        }
        else{
            Session()->flash('error','Thêm không hợp lệ vui lòng nhập lại');
            return redirect()->back();
        }
    }
    public function delete_all_cart(){
        $cart = Session::get('cart');
        if($cart){
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back();
        }
    }
    public function check_coupon(Request $request){
        $coupon = Coupon::where('coupon_code',$request->coupon)->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }
                }
                else{
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                Session()->flash('success','Thêm mã giảm giá thành công');
                return redirect()->back();
            }
        }else{
            Session()->flash('error','Thêm mã giảm giá không hợp lệ vui lòng nhập lại');
            return redirect()->back();
        }
    }
}
