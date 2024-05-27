<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\AdminDistributorMaster;
use App\AdminProductMaster;
use App\AdminCustomerMaster;
use App\AdminEmployeeMaster;
use App\Login;


class AdminDashboardController extends Controller {

    public function __construct() {
        $session = Session::get('admin_login');

        if($session =='' || $session ==null){
            return redirect('admin');
        }
    }
    public function index(){
          $session = Session::get('admin_login');

        if($session =='' || $session ==null){
            return redirect('admin');
        }else{
           $this->data['admin_login'] = Session::get('admin_login');
           $this->data['total_product'] = AdminProductMaster::productList();
           $this->data['total_customer'] = AdminCustomerMaster::customerList();
           $this->data['total_employee'] = AdminEmployeeMaster::employeeList();
           $this->data['total_distributor'] = AdminDistributorMaster::distributorList();
        }
        return view('dashboard',$this->data);
    }

}
