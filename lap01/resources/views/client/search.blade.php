@extends('layout')
@section('home_content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Sản phẩm tìm kiếm</h2>
        @foreach($search_product as $value)
            <div class="col-sm-4">
                <a href="{{url('chi-tiet-san-pham/'.$value->product_id)}}">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{url('public/upload/product/'.$value->product_image)}}" alt="" />
                                <h2>{{number_format($value->product_price).' VNĐ'}}</h2>
                                <p>{{$value->product_name}}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                            </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>Mua hàng</a></li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
