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

            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
                <div class="table-responsive cart_info">
                    <?php
                    $content = Cart::content();
                    ?>
                    <table class="table table-condensed">
                        <thead>
                        <tr class="cart_menu">
                            <td class="description">Tên sản phẩm</td>
                            <td class="image">Ảnh</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Tổng tiền</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($content as $value)
                            <tr>
                                <td class="cart_description">
                                    <h4><a href="">{{$value->name}}</a></h4>
                                </td>
                                <td class="">
                                    <a href=""><img height="100px" width="100px" src="{{url('public/upload/product/'.$value->options->image)}}" alt=""></a>
                                </td>
                                <td class="cart_price">
                                    <p>{{number_format($value->price).' VNĐ'}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_up" href=""> + </a>
                                        <input class="cart_quantity_input" type="text" name="quantity" value="{{$value->qty}}" autocomplete="off" size="2">
                                        <a class="cart_quantity_down" href=""> - </a>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        {{number_format($subtotal = $value->price* $value->qty).' VNĐ'}}
                                    </p>
                                </td>
                                <td class="cart_delete" style="margin-top: 32px;padding-left: 0">
                                    <a class="cart_quantity_delete" href="{{url('delete-cart/'.$value->rowId)}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="payment-options">
                <H3>Hình Thức Thanh Toán</H3>
                <form action="{{url('order-place')}}" method="post">
                @csrf
					<span>
						<label><input type="checkbox" name="payment_option" value="bằng ATM"> Chuyển tiền qua ATM</label>
					</span>
                <span>
						<label><input type="checkbox" name="payment_option" value="tiền mặt"> Thanh toán khi nhận hàng</label>
					</span>
{{--                <span>--}}
{{--						<label><input type="checkbox"> Paypal</label>--}}
{{--					</span>--}}
                    <input type="submit" value="Đặt hàng" class="btn-primary btn btn-sm">
                </form>
            </div>
        </div>
    </section> <!--/#cart_items-->
@endsection
