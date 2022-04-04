@extends('layout')
@section('home_content')
    <div class="features_items"><!--features_items-->
        @foreach($data_brand_name as $value)
        <h2 class="title text-center">{{$value->brand_name}}</h2>
        @endforeach
            @foreach($data_brandshow as $value)
            <div class="col-sm-4">
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
            </div>
            @endforeach
    </div>
@endsection
