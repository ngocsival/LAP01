@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        @foreach($info as $value)
                        <form role="form" action="{{route('edit-product')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" value="{{$value->product_name}}" name="product_name"  class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file"  name="product_image"  class="form-control" id="exampleInputEmail1" >
                                <image style="width: 100px;height: 100px" src="{{url('public/upload/product/'.$value->product_image)}}"></image>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea name="product_desc" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$value->product_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea name="product_content" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1" placeholder="Nội dung">{{$value->product_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía sản phẩm</label>
                                <input type="text" name="product_price" value="{{$value->product_price}}"  class="form-control" id="exampleInputEmail1" placeholder="Gía sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Danh mục sản phẩm</label>

                                <select name="product_category" class="form-control input-sm m-bot15">
                                    @foreach($data_category as $value2)
                                        @if($value2->category_id==$value->category_id)
                                        <option selected value="{{$value2->category_id}}">{{$value2->category_name}}</option>
                                        @else
                                            <option value="{{$value2->category_id}}">{{$value2->category_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Thương hiệu sản phẩm</label>
                                <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($data_brand as $value3)
                                        @if($value3->brand_id==$value->brand_id)
                                        <option selected value="{{$value3->brand_id}}">{{$value3->brand_name}}</option>
                                        @else
                                            <option value="{{$value3->brand_id}}">{{$value3->brand_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    @if($value->product_status==0)
                                        <option selected value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    @else
                                        <option value="0">Ẩn</option>
                                        <option selected value="1">Hiện</option>
                                    @endif
                                </select>
                            </div>
                            <input  type="text" value="{{$value->product_id}}" name="product_id" hidden="" >
                            <button type="submit" class="btn btn-info">Cập nhật</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
@endsection

