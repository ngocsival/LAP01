<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Shiping;
use App\Models\OrderDetails;
class CheckoutController extends Controller
{
    public function show_login(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('client.login',$category,$brand);
    }
    public function add_customer(Request $request){
        $customer_id=DB::table('customer')->insertGetId([
            'customer_name'=>$request->customer_name,
            'customer_email'=>$request->customer_email,
            'customer_password'=>md5($request->customer_password),
            'customer_phone'=>$request->customer_phone,
        ]);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return redirect('checkout');
    }
    public function checkout(){
        $city['city'] = City::orderby('matp','ASC')->get();
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('client.checkout',$brand,$category)->with($city);
    }
    public function save_checkout(Request $request){
        $shipping_id = DB::table('tbl_shiping')->insertGetId([
            'shipping_name'=>$request->shipping_name,
            'shipping_email'=>$request->shipping_email,
            'shipping_address'=>$request->shipping_address,
            'customer_id'=>Session::get('customer_id'),
            'shipping_phone'=>$request->shipping_phone,
            'shipping_note'=>$request->shipping_note,
        ]);
        Session::put('shipping_id',$shipping_id);
        return redirect('payment');
    }
    public function payment(){
        $category['data_category'] = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand['data_brand'] = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('client.payment',$brand,$category);
    }
    public function logout_checkout(){
        Session::flush();
        return redirect('login-checkout');
    }
    public function login_customer(Request $request){
        $username = $request->email_checkout;
        $password = md5($request->password_checkout);
        $result = DB::table('customer')->where('customer_email',$username)->where('customer_password',$password)->first();
        if($result) {
            Session::put('customer_id',$result->customer_id);
            return redirect('checkout');
        }
        else{
            Session::flash('error','Tài khoản hoặc mật khẩu sai!');
            return redirect('login-checkout');
        }
    }
    public function order_place(Request $request){
        $payment_id = DB::table('tbl_payment')->insertGetId([
            'payment_method'=>$request->payment_option,
            'payment_status'=>'đang chờ xử lý',
        ]);
        $order_id = DB::table('tbl_order')->insertGetId([
            'customer_id'=>Session::get('customer_id'),
            'shipping_id'=>Session::get('shipping_id'),
            'payment_id'=>$payment_id,
            'order_total'=>Cart::total(),
            'order_status'=>'đang chờ xử lý'
        ]);
        $content = Cart::content();
        foreach ($content as $value) {
            DB::table('tbl_order_details')->insert([
                'order_id' => $order_id,
                'product_id' => $value->id,
                'product_name' => $value->name,
                'product_price' => $value->price,
                'product_sales_quantity' => $value->qty,
            ]);
        }
        if($request->payment_option==0){
            echo 'thanh toán bằng thẻ';
        }
        else{
            echo 'thanh toán bằng tiền mặt';
        }
    }
    public function manage_order(){
        $result['data'] = DB::table('tbl_order')
            ->join('customer', 'tbl_order.customer_id', '=', 'customer.customer_id')
            ->select('tbl_order.*','customer.customer_name')
            ->orderBy('tbl_order.order_id','desc')
            ->get();
        $manage_order['data'] = view('admin.manage_order',$result);
        return view('admin.admin_layout',$manage_order);
    }
    public function view_order(Request $request){
        $result['data'] = DB::table('tbl_order')
            ->join('customer', 'tbl_order.customer_id', '=', 'customer.customer_id')
            ->join('tbl_shiping', 'tbl_order.shipping_id', '=', 'tbl_shiping.shipping_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*','tbl_order_details.*','tbl_shiping.*','customer.*')
            ->where('tbl_order.order_id',$request->id)
            ->first();
        echo '<pre>';
        print_r($result);
    }
    public function select_delivery_home(Request $request){
        if($request->action){
            $output = '';
            if($request->action=='city'){
                $select_province = Province::where('matp',$request->ma_id)->orderby('maqh','ASC')->get();
                $output .='<option>----Chọn Quận Huyện----</option>';
                foreach ($select_province as $key =>$province){
                    $output .= '<option value="'.$province->maqh.'">'. $province->name_qh.'</option>';
                }
            }
            else{
                $select_wards = Wards::where('maqh',$request->ma_id)->orderby('xaid','ASC')->get();
                $output .='<option>----Chọn Xã Phường Thị Trấn----</option>';
                foreach ($select_wards as $key =>$wards){
                    $output .= '<option value="'.$wards->xaid.'">'.$wards->name_xptt.'</option>';
                }
            }
            echo $output;
        }
    }
    public function calculate_delivery(Request $request){
        $calculate_fee = Feeship::where('fee_matp',$request->matp)->where('fee_maqh',$request->maqh)->where('fee_xaid',$request->xaid)->get();
        if($calculate_fee){
            foreach ($calculate_fee as $fee)
            Session::put('fee',$fee->fee_feeship);
            Session::save();
        }
    }
    public function confirm_order(Request $request){
        $data = $request->all();

        $shipping = new Shiping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['payment_select'];
        $shipping->customer_id = Session::get('customer_id');
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);


        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }
}
