<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
session_start();

class AdminController extends Controller
{
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return redirect('dashboard');
        }
        else{
            return redirect('admin')->send();
        }
    }
    public function index(){
        return view('admin.admin_login');
    }
    public function show_dashboard(){
        $this->Authlogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $username = $request->admin_email;
        $password = md5($request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email',$username)->where('admin_password',$password)->first();
        if($result) {
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return redirect('dashboard');
        }
        else{
            Session::put('message','Tài khoản hoặc mật khẩu sai!');
            return redirect('admin');
        }
    }
    public function log_out(){
        $this->Authlogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return view('admin.admin_login');
    }
}
