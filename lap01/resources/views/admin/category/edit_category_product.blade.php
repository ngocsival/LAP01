@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa danh mục sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{route('edit-category-product')}}" method="post">
                            @foreach($info as $value)
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input value="{{$value->category_name}}" type="text" name="category_product_name"  class="form-control" id="exampleInputEmail1" placeholder="Tenn danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea name="category_product_desc" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$value->category_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Hiển thị</label>
                                <select name="category_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
                                </select>
                            </div>
                                <input value="{{$value->category_id}}" type="text" name="category_product_id" hidden="">
                            <button type="submit" class="btn btn-info">Sửa</button>
                            @endforeach
                            @csrf
                        </form>
                    </div>

                </div>
            </section>
        </div>
@endsection
