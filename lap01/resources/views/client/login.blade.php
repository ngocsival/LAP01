@extends('layout')
@section('home_content')
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
            <div class="login-form"><!--login form-->
                <h2>Đăng Nhập</h2>
                @include('admin.alert')
                <form action="{{url('login-customer')}}" method="post">
                    @csrf
                    <input type="email" placeholder="Nhập email" name="email_checkout" />
                    <input type="password" placeholder="Nhập mật khẩu" name="password_checkout" />
                    <span>
								<input type="checkbox" class="checkbox">
								Nhớ mật khẩu
							</span>
                    <button type="submit" class="btn btn-default">Đăng nhập</button>
                </form>
            </div><!--/login form-->
        </div>
        <div class="col-sm-1">
            <h2 class="or">OR</h2>
        </div>
        <div class="col-sm-4">
            <div class="signup-form"><!--sign up form-->
                <h2>Tạo tài khoản mới</h2>
                <form action="{{url('add-customer')}}" method="post">
                    @csrf
                    <input type="text" placeholder="Nhập name" name="customer_name"/>
                    <input type="email" placeholder="Nhập email" name="customer_email"/>
                    <input type="password" placeholder="Nhập Password" name="customer_password"/>
                    <input type="text" placeholder="Nhập số điện thoại" name="customer_phone">
                    <button type="submit" class="btn btn-default">Đăng ký</button>
                </form>
            </div><!--/sign up form-->
        </div>
    </div>
@endsection
