@extends('layout')
@section('home_content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('')}}">Trang chủ</a></li>
                    <li class="active">Thanh Toán</li>
                </ol>
            </div><!--/breadcrums-->
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-10 clearfix">
                        @include('admin.alert')
                        <div class="bill-to">
                            <p>Điền thông tin gửi hàng</p>
                            <div class="form-one">
                                <form >
                                    @csrf
                                    <input type="text" name="shipping_email" class="shipping_email" placeholder="Email">
                                    <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ Tên">
                                    <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
                                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ giao hàng">
                                    <textarea name="shipping_note" class="shipping_note"  placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>
                                    @if(Session::get('fee'))
                                        <input name="order_fee" type="hidden" class="order_fee" value="{{Session::get('fee')}}">
                                    @else
                                        <input name="order_fee" type="hidden" class="order_fee" value="10000">
                                    @endif
                                    @if(Session::get('coupon'))
                                        @foreach(Session::get('coupon') as $cou)
                                        <input name="order_coupon" type="hidden" class="order_coupon" value="{{$cou['coupon_code']}}">
                                        @endforeach
                                    @else
                                        <input name="order_coupon" type="hidden" class="order_coupon" value="0">
                                    @endif
                                    <div>
                                        <div class="form-group">
                                            <lable class="">
                                                Chọn hình thức thanh toán
                                                <select name="payment_select" class="form-control input-sm payment_select">
                                                    <option value="0">Chuyển Khoản</option>
                                                    <option value="1">Tiền mặt</option>
                                                </select>
                                            </lable>
                                        </div>
                                    </div>
                                    <input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                                </form>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="position-center">
                                <form>
                                    @csrf
                                    <div class="form-group">
                                        <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                            <option value="">------*Chọn thành phố*------</option>
                                            @foreach($city as $val_city)
                                                <option value="{{$val_city->matp}}">{{$val_city->name_tp}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Chọn quận huyện</label>
                                        <select name="province" id="province" class="form-control input-sm m-bot15 choose province">
                                            <option value="">------*Chọn quận huyện*------</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Chọn xã phường thị trấn</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                            <option value="">------*Chọn xã phường thị trấn*------</option>
                                        </select>
                                    </div>
                                    <button type="button" name="calculate_delivery" class="btn btn-info calculate_delivery">Tính phí vận chuyện</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive cart_info">
                            <table class="table table-condensed">
                                <form action="{{url('/update-cart')}}" method="post">
                                    <thead>
                                    <tr class="cart_menu">
                                        <th class="image">Hình ảnh</th>
                                        <th class="description">Tên sản phẩm</th>
                                        <th class="price">Giá sản phẩm</th>
                                        <th class="quantity">Số lượng</th>
                                        <th class="total">Thành tiền</th>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(Session::has('cart'))
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach(Session::get('cart') as $key => $cart)
                                            <?php
                                            $subtotal = $cart['product_price'] * $cart['product_qty'];
                                            $total += $subtotal;
                                            ?>

                                            <tr>
                                                <td class="cart_product">
                                                    <img src="{{asset('public/upload/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
                                                </td>
                                                <td class="cart_description">
                                                    <h4><a href=""></a></h4>
                                                    <p>{{$cart['product_name']}}</p>
                                                </td>
                                                <td class="cart_price">
                                                    <p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
                                                </td>
                                                <td class="cart_quantity">
                                                    <div class="cart_quantity_button">

                                                        <input class="cart_quantity_" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >

                                                    </div>
                                                </td>
                                                <td class="cart_total">
                                                    <p class="cart_total_price">
                                                        {{number_format($subtotal,0,',','.')}}đ

                                                    </p>
                                                </td>
                                                @csrf
                                                <td class="cart_delete">
                                                    <a class="cart_quantity_delete" href="{{url('delete-cart-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-default check_out">
                                            </td>
                                            <td>
                                                <a class="btn btn-default check_out" href="{{url('delete-all-cart')}}">Xóa tất cả</a>
                                            </td>
                                            <td>
                                                <li>Tổng <span>{{number_format($total,0,',','.')}}đ </span></li>
                                                <li>
                                                    @if(Session::get('coupon'))
                                                        @foreach(Session::get('coupon') as $key =>$cou)
                                                            @if($cou['coupon_condition']==1)
                                                                Mã Gỉam :{{$cou['coupon_number']}}%
                                                                <p>
                                                                    @php
                                                                        $total_coupon = ($total* $cou['coupon_number'])/100;
                                                                        echo
                                                                        '<p><li>Tổng giảm:'.number_format($total_coupon,0,',','.').'đ
                                                                        </li></p>'
                                                                    @endphp
                                                                </p>
                                                                <p><li>Tổng đã giảm:{{number_format($total-$total_coupon-(Session::get('fee')),0,',','.')}}đ</li></p>
                                                @elseif($cou['coupon_condition']==2)
                                                    Mã Giảm :{{number_format($cou['coupon_number'],0,',','.')}}đ
                                                    <p>
                                                        @php
                                                            $total_coupon = $total- $cou['coupon_number']-(Session::get('fee'));
                                                        @endphp
                                                    </p>
                                                    <p><li>Tổng đã giảm:{{number_format($total_coupon,0,',','.')}}đ</li></p>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                @if(Session::get('fee'))
                                                    <li>Tiền ship:   {{number_format(Session::get('fee'),0,',','.')}}đ</li>
                                                    @endif
                                                    </li>
                                                    {{--                                <li>Thuế: <span></span></li>--}}
                                                    {{--                                <li>Tiền sau giảm: <span></span></li>--}}
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </form>
                                <tr>
                                    <td>
                                        <form action="{{url('check-coupon')}}" method="post">
                                            @csrf
                                            <input name="coupon" type="text" placeholder="Vui lòng nhập mã khuyến mại nếu có" class="form-control"><br>
                                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" >
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--/#cart_items-->
@endsection
