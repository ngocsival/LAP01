<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function insert_coupon_code(){
        return view('admin.coupon.insert_coupon');
    }
    public function save_coupon_code(Request $request){
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'coupon_code'=>$request->coupon_code,
            'coupon_condition'=>$request->coupon_condition,
            'coupon_number'=>$request->coupon_number,
            'coupon_time'=>$request->coupon_time,
        ]);
        Session::flash('success','Thêm mã giảm giá thành công');
        return redirect()->back();
    }
    public function list_coupon(){
        $data['data'] = Coupon::all();
        return view('admin.coupon.list_coupon',$data);
    }
}
