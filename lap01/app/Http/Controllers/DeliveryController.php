<?php

namespace App\Http\Controllers;

use App\Models\Feeship;
use Illuminate\Http\Request;
use App\Models\Wards;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Session;
class DeliveryController extends Controller
{
    public function delivery(){
        $city['city'] = City::orderby('matp','ASC')->get();
        return view('admin.delivery.add_delivery',$city);
    }
    public function select_delivery(Request $request){
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
    public function add_delivery(Request $request){
        Feeship::insert([
            'fee_matp'=>$request->city,
            'fee_maqh'=>$request->province,
            'fee_xaid'=>$request->wards,
            'fee_feeship'=>$request->fee_ship,
        ]);
    }
    public function select_feeship(){
        $feeship = Feeship::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '<div class="table-responsive">
			<table class="table table-bordered">
				<thread>
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th>
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>
				</thread>
				<tbody>
				';

        foreach($feeship as $key => $fee){

            $output.='
					<tr>
						<td>'.$fee->city->name_tp.'</td>
						<td>'.$fee->province->name_qh.'</td>
						<td>'.$fee->wards->name_xptt.'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
					</tr>
					';
        }

        $output.='
				</tbody>
				</table></div>
				';

        echo $output;


    }
    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
