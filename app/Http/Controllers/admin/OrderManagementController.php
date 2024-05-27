<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ordermaster;

use App\Http\Traits\ImageUploadTrait;

class OrderManagementController extends Controller
{
    use ImageUploadTrait;
    public function index(Request $request)
    {
        $this->data['userName'] = $userName = $request->userName;
        $this->data['orderType'] = $orderType = $request->order_type;
        $this->data['orderNumber']=$orderNumber = $request->order_number;
        $this->data['orderStatus']=$orderStatus = $request->order_status;
        $this->data['deliveryCharge'] = $deliveryCharge = $request->delivery_charge;
        $this->data['totalAmount'] = $totalAmount = $request->total_amount;

        $this->data['orderManagementList'] = OrderMaster::getOrderBySearchValue($userName,$orderType,$orderNumber,$orderStatus,$deliveryCharge,$totalAmount);
        $this->data['orderManagementListAll']=Ordermaster::getOrder();
        $this->data['module'] = 'Order Management List';
        return view('admin.ordermanagement.index', $this->data);
    }

    public function show($id)
    {
        $this->data['module'] = 'Order Report';
        $this->data['order']=Ordermaster::findOrder($id);
        return view('admin.ordermanagement.show',$this->data);
    }
}
