@extends('layout')
@section('home_content')
    <section id="do_action">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="col-sm-10 clearfix">
                <div class="table-responsive cart_info">
                @include('admin.alert')
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
                                                <p><li>Tổng đã giảm:{{number_format($total-$total_coupon,0,',','.')}}đ</li></p>
                                            @elseif($cou['coupon_condition']==2)
                                            Mã Giảm :{{number_format($cou['coupon_number'],0,',','.')}}đ
                                            <p>
                                                @php
                                                    $total_coupon = $total- $cou['coupon_number'];
                                                @endphp
                                            </p>
                                            <p><li>Tổng đã giảm:{{number_format($total_coupon,0,',','.')}}đ</li></p>
                                            @endif
                                        @endforeach
                                    @endif
                                </li>
{{--                                <li>Thuế: <span></span></li>--}}
{{--                                <li>Phí vận chuyển <span>Free</span></li>--}}
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
    </section>
{{--    <section id="do_action">--}}
{{--        <div class="container">--}}
{{--            <div class="heading">--}}
{{--                <h3>What would you like to do next?</h3>--}}
{{--                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <div class="chose_area">--}}
{{--                        <ul class="user_option">--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Use Coupon Code</label>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Use Gift Voucher</label>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <input type="checkbox">--}}
{{--                                <label>Estimate Shipping & Taxes</label>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <ul class="user_info">--}}
{{--                            <li class="single_field">--}}
{{--                                <label>Country:</label>--}}
{{--                                <select>--}}
{{--                                    <option>United States</option>--}}
{{--                                    <option>Bangladesh</option>--}}
{{--                                    <option>UK</option>--}}
{{--                                    <option>India</option>--}}
{{--                                    <option>Pakistan</option>--}}
{{--                                    <option>Ucrane</option>--}}
{{--                                    <option>Canada</option>--}}
{{--                                    <option>Dubai</option>--}}
{{--                                </select>--}}

{{--                            </li>--}}
{{--                            <li class="single_field">--}}
{{--                                <label>Region / State:</label>--}}
{{--                                <select>--}}
{{--                                    <option>Select</option>--}}
{{--                                    <option>Dhaka</option>--}}
{{--                                    <option>London</option>--}}
{{--                                    <option>Dillih</option>--}}
{{--                                    <option>Lahore</option>--}}
{{--                                    <option>Alaska</option>--}}
{{--                                    <option>Canada</option>--}}
{{--                                    <option>Dubai</option>--}}
{{--                                </select>--}}

{{--                            </li>--}}
{{--                            <li class="single_field zip-field">--}}
{{--                                <label>Zip Code:</label>--}}
{{--                                <input type="text">--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <a class="btn btn-default update" href="">Get Quotes</a>--}}
{{--                        <a class="btn btn-default check_out" href="">Continue</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6">--}}
{{--                    <div class="total_area">--}}
{{--                        <ul>--}}
{{--                            <li>Tổng <span></span></li>--}}
{{--                            <li>Thuế <span></span></li>--}}
{{--                            <li>Phí vận chuyển <span>Free</span></li>--}}
{{--                            <li>Tiền sau giảm:{{number_format($total,0,',','.')}}đ <span></span></li>--}}
{{--                        </ul>--}}
{{--                        <a class="btn btn-default check_out" href="">Thanh toán</a>--}}
{{--                        <a class="btn btn-default check_out" href="">Tính mã giảm giá</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        </div>--}}
{{--    </section>--}}
@endsection

