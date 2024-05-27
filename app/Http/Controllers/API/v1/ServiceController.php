<?php
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use App\Helpers\AttachMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\AdminEmployeeMaster;
use App\AdminProductMaster;
use App\AdminCustomerMaster;
use App\ProductOrder;
use App\StockMaster;
use App\OrderItems;
use App\NoteMaster;
use App\Announcement;
use App\EmployeeStockLog;
use App\Helpers\SlugHelper;
use URL;
class ServiceController extends Controller{

	/*******start login service *******/
	public function login(Request $request){

		$email = Input::get('email');
		$password = Input::get('password');

		if($email !='' && $password !=''){
		/**************Start check email address account create or not *****************/

		$CheckAccountByEmailAddress = AdminEmployeeMaster::CheckAccountByEmailAddress($email);

		/**************End eheck email address account create or not *************/
			if($CheckAccountByEmailAddress ==1){
				//echo md5($password);die;
				/*Start get reponse by Emailaddress and password */
				$GetResponseByEmail = AdminEmployeeMaster::GetResponseByEmail($email,$password);

				if(!empty($GetResponseByEmail)){
					return response(['status'=>"1","error_msg"=>"Login success.","data"=>array($GetResponseByEmail)]);
				}else{
					return response(['status'=>"0","error_msg"=>"Invalid email address or password.","data"=>""]);
				}

				/*End get reponse by Emailaddress and password*/

			}else{
				return response(['status'=>"0","error_msg"=>"Please contact admin for creating new account!","data"=>""]);
			}

		}else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}

	/*******end login service *******/

	/*******start Forgotpassword service *******/
	public function forgotPassword(Request $request){

		$email = Input::get('email');
		if($email !=''){
		/**************Start check email address account create or not *****************/

		$CheckAccountByEmailAddress = AdminEmployeeMaster::CheckAccountByEmailAddress($email);
		/**************End eheck email address account create or not *************/
			if($CheckAccountByEmailAddress ==1){
				/*Start get reponse by Emailaddress and password */
				$GetResponseByEmail = AdminEmployeeMaster::GetResponseByEmailForforgotpass($email);


					$randotp = substr(str_shuffle("123456789"), 0, 4);

					 $data_array = array(
                    'otp' => $randotp
					);
				    $update = AdminEmployeeMaster::where('id', $GetResponseByEmail->id)->update($data_array);

					if($update)
					{
						$html = '<html><head>
						<style>
							#messagebody
							{
								margin-left:20px;margin-right:40px;margin-bottom:100px;line-height:24px;font-size:14px;
							}
						</style>
						</head>
						<body>
							<div id="messagebody">
								Hello ' . $GetResponseByEmail->name . ',<br /><br />We have received your password reset request. <br /> To reset your password please enter this OTP : <strong>' . $randotp . '</strong>.
								<br /></br />
								Thank you,
							</div>
						</body>
						</html>';
						$mailer = AttachMailer::send("morfose@gmail.com", $GetResponseByEmail->email_id, 'Morfose Password Reset', $html, "", "morfose@gmail.com");
					}
					$GetResponseByEmail = AdminEmployeeMaster::GetResponseByEmailForforgotpass($email);
					$data['id'] = $GetResponseByEmail->id;
					$data['otp'] = $GetResponseByEmail->otp;
					return response(['status'=>"1","error_msg"=>"We have sent you email for the OTP.","data"=>array($data)]);

				/*End get reponse by Emailaddress and password*/

			}else{
				return response(['status'=>"0","error_msg"=>"Please Enter Correct Email Address!","data"=>""]);
			}

		}else{
			return response(['status'=>"0","error_msg"=>"Please provide Email.","data"=>""]);
		}
	}

	/*******end Forgotpassword service *******/


	/********verify otp**********************/

	public function  verifyOtp(Request $request){
		$otp = Input::get('otp');
		$id = Input::get('id');

		if($otp != "" && $id != ""){
		$CheckOtpById = AdminEmployeeMaster::checkOtpById($otp,$id);
		/**************End eheck email address account create or not *************/
			if($CheckOtpById){
				return response(['status'=>"1","error_msg"=>"OTP verified!","data"=>$CheckOtpById]);
			}else{
				return response(['status'=>"0","error_msg"=>"Invalid OTP Please try again!","data"=>""]);
			}
		}else{
			return response(['status'=>"0","error_msg"=>"Required Parameter is Missing.","data"=>""]);
		}

	}
	/********End verify otp**********************/

	/********reset Password**********************/
	public function  resetPassword(Request $request){
		$password = Input::get('password');
		$id = Input::get('id');

		if($password != "" && $id != ""){
		$checkById = AdminEmployeeMaster::checkById($id);
		/**************End eheck email address account create or not *************/
			if($checkById){
				$data_array = array(
				'password' => md5($password),
				'otp'=>null
				);
				$update = AdminEmployeeMaster::where('id', $id)->update($data_array);
				$getData = AdminEmployeeMaster::checkById($id);
				return response(['status'=>"1","error_msg"=>"Password Updated Successfully!","data"=>$getData]);
			}else{
				return response(['status'=>"0","error_msg"=>"Data Not Found!","data"=>""]);
			}
		}else{
			return response(['status'=>"0","error_msg"=>"Required Parameter is Missing.","data"=>""]);
		}

	}

	/********Reset Password End**********************/


	/********Start get Product List**********************/
	public function getProductList(Request $request){
		$productdata = AdminProductMaster::productList();
        if(count($productdata) != 0){
			foreach ($productdata as $data) {

				$available_stock=StockMaster::getRecordByproductId($data->id);
				$data['defaultCartquntity'] = 1;
				if($available_stock)
				{
				$data['available_stock'] = $available_stock->available_stock;
				}
				else{
					$data['available_stock'] = 0;
				}
			}
			return response(['status'=>"1","error_msg"=>"","data"=>$productdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	/********End get Product List**********************/

	/********Start get Product List**********************/
	public function getEmployeeListByEmail(Request $request){

		$email = Input::get('email');
		$employeedata = AdminEmployeeMaster::getEmployeeDataByEmail($email);
		if($employeedata){
			return response(['status'=>"1","error_msg"=>"","data"=>$employeedata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	/********End get Product List**********************/

	/*******start Change password service *******/
	public function changeEmployeePassword(Request $request){

		$id = Input::get('id');
		$oldpassword = Input::get('old_password');
		$newpassword = Input::get('new_password');


		if($oldpassword !='' && $newpassword !=''){
		/**************Start check old password or not *****************/
	     $checkoldpass = AdminEmployeeMaster::checkPassword($id,$oldpassword);
		 if($checkoldpass)
		 {
			  $updatepassword = AdminEmployeeMaster::where("id", $id)->update(array("password" => md5($newpassword)));
			  return response(['status'=>"1","error_msg"=>"Your password updated successfully","data"=>""]);
		 }
		 else{
			 return response(['status'=>"0","error_msg"=>"Please provide correct old password.","data"=>""]);
		 }


		}else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}
	/*******End Change password service *******/


	/*******Start Update employee profile service *******/
	public function updateEmployeeProfile(Request $request){

		$name = Input::post('name');
		$city = Input::post('city');
		$email = Input::post('email');
		$address = Input::post('address');
		$date_of_birth = Input::post('date_of_birth');
		$post_code = Input::post('post_code');
		$contact = Input::post('contact');
		$id = Input::post('id');

		if($email && $post_code && $contact && $name && $address){
		/**************Start check old password or not *****************/
		$data=AdminEmployeeMaster::editRecordById($id);
		$old_name = $data->name;
			 if($request->file('image') !=''){
                    $image = $request->file('image');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/employee');
                    $image->move($destinationPath, $photo);
                }else{

                    $photo = $data->image;
                }
								$data_array = array(
				                     'name' => $name,
				 					'address'=> $address,
				 					'posal_code'=> $post_code,
				 					'email_id'=> $email,
				 					'contact'=> $contact,
				 					'image' => $photo,
				                     'updated_date' => date('Y-m-d H:i:s'),
				                     'updated_by' => $id
				                 );
if($date_of_birth != '') {
	$data_array['date_of_birth'] = $date_of_birth;
}
if($city != '') {
	$data_array['city'] = $city;
}
                if($name != $old_name){
                     $slug =SlugHelper::slug($name,'mf_employee_master', $field = 'slug', $key = NULL, $value = NULL);
                     $data_array['slug'] = $slug;
                }

                $update = AdminEmployeeMaster::where('id', $id)->update($data_array);
				if($update)
				{
					$Employeedata = AdminEmployeeMaster::editRecordById($id);
					return response(['status'=>"1","error_msg"=>"Profile updated successfully","data"=>array($Employeedata)]);
				}
				else
				{
					return response(['status'=>"0","error_msg"=>"Sorry, something went wrong. Please try again.","data"=>""]);
				}


		}else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}
	/*******End Update employee profile service *******/



		/********Start get Customer List**********************/
	public function getCustomerList(Request $request){
		$customerdata = AdminCustomerMaster::customerList();
		if(count($customerdata) != 0){
			return response(['status'=>"1","error_msg"=>"","data"=>$customerdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	/********End get Customer List**********************/
	public function addCustomer(Request $request){

		$name = Input::get('name');
		$address = Input::get('address');
		$post_code = Input::get('post_code');
		$email = Input::get('email');
		$contact = Input::get('contact');
		$type = Input::get('type');
		$notes = Input::get('notes');
		$login_id = Input::get('login_id');

		if($name && $address && $post_code && $email && $contact)
		{
			$exitemail=AdminCustomerMaster::checkExitEmail($email);
			if($exitemail)
			{
				return response(['status'=>"0","error_msg"=>"Email is already exits.","data"=>""]);
			}
			else
			{
			/**************Start check old password or not *****************/
			$slug =SlugHelper::slug($name,'mf_customer_master', $field = 'slug', $key = NULL, $value = NULL);
				$data_array = array(
					'name' => $name,
					'address' => $address,
					'posal_code' => $post_code,
					'email_id'=> $email,
					'contact'=> $contact,
					'type'=> $type,
					'notes'=>$notes,
					 'slug' => $slug,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $login_id
				);

				$insert = new AdminCustomerMaster($data_array);
				$insert->save();
				$update = $insert->id;
				return response(['status'=>"1","error_msg"=>"Customer inserted successfully","data"=>""]);

			}
		}
		else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}

	public function editCustomer(Request $request){


		$id = Input::get('id');
		$name = Input::get('name');
		$address = Input::get('address');
		$post_code = Input::get('post_code');
		$email = Input::get('email');
		$contact = Input::get('contact');
		$type = Input::get('type');
		$notes = Input::get('notes');
		$login_id = Input::get('login_id');

		if($name && $address && $post_code && $email && $contact)
		{
			$exitemail=AdminCustomerMaster::checkExitEmailForedit($email,$id);
			if($exitemail)
			{
				return response(['status'=>"0","error_msg"=>"Email is already exits.","data"=>""]);
			}
			else
			{
			/**************Start check old password or not *****************/

				$data_array = array(
					'name' => $name,
					'address' => $address,
					'posal_code' => $post_code,
					'email_id'=> $email,
					'contact'=> $contact,
					'type'=> $type,
					'notes'=>$notes,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $login_id
				);

				$update = AdminCustomerMaster::where('id', $id)->update($data_array);

				if($update)
				{
					$customerarray = AdminCustomerMaster::editRecordById($id);
					return response(['status'=>"1","error_msg"=>"Customer Updated successfully","data"=>array($customerarray)]);
				}
				else{
					return response(['status'=>"0","error_msg"=>"Sorry, something went wrong. Please try again.","data"=>""]);
				}

			}
		}
		else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}

	public function addNewOrder(Request $request){

		$employee_id = Input::get('employee_id');
		$customer_id = Input::get('customer_id');
		$products = json_decode(Input::get('products'));
		$discount = Input::get('discount');
		$discount_amount = Input::get('discount_amount');
		$total = Input::get('total');
		$note = Input::get('note');


		if($employee_id && $customer_id && $total && $products)
		{

			/**************Start check old password or not *****************/


				$data_array = array(
					'employee_id' => $employee_id,
					'customer_id' => $customer_id,
					'discount' => $discount,
					'discount_value' => $discount_amount,
					'total'=> $total,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $employee_id
				);

				$insert = new ProductOrder($data_array);
				$insert->save();
				$insert_id = $insert->id;

				if($insert_id)
				{
					  if(isset($note))
				{
					$notedata_array = array(
						'product_order_fk'=>$insert_id,
					'employee_id' => $employee_id,
					'customer_id' => $customer_id,
					'note'=>$note,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $employee_id
				);

				$insertnote = new NoteMaster($notedata_array);
				$insertnote->save();
				$inser_note = $insertnote->id;
				}

					foreach($products as $products_data)
					{


                        /*Start Stock master*/
                        $available_stock=StockMaster::getRecordByproductId($products_data->product_id);

						if($available_stock)
						{
						$oldstock = $available_stock->available_stock;

						$newstock  = $oldstock - $products_data->quantity;


                         $stock_array = array(
						'available_stock' => $newstock
						);

						$update = StockMaster::where('id', $available_stock->id)->update($stock_array);
                        }
						/*End Stock master*/


						 /*Start employee Stock master*/
                        $available_employee_stock=EmployeeStockLog::getRecordByproductId($products_data->product_id);

						if($available_employee_stock)
						{
						$oldstock = $available_employee_stock->total_quantity;

						$newstock  = $oldstock - $products_data->quantity;


                         $employee_stock_array = array(
						'total_quantity' => $newstock
						);

						$update = EmployeeStockLog::where('id', $available_employee_stock->id)->update($employee_stock_array);
                        }
						/*End empoloyee Stock master*/



						$product_array = array(
						'product_order_id' => $insert_id,
						'product_id' => $products_data->product_id,
						'quantity' => $products_data->quantity,
						'created_date' => date('Y-m-d H:i:s'),
						'created_by' => $employee_id
						);

						$insert = new OrderItems($product_array);
						$insert->save();
					}
				}
				return response(['status'=>"1","error_msg"=>"Order inserted successfully","data"=>""]);
		}
		else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}


	public function getOrderListByEmployee(Request $request){

		$id = Input::get('id');
		$productdata = ProductOrder::getAllOrderByemployeeId($id);

		$iteamdat=array();

		foreach($productdata as $pdata)
		{
			$iteamdat = OrderItems::getAlliteamsByemployeeId($pdata->id);
			$pdata->iteamdetail=$iteamdat;

		}

		if(count($productdata) != 0){
			return response(['status'=>"1","error_msg"=>"","data"=>$productdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}

	public function getOrderListByCustomer(Request $request){

		$id = Input::get('id');
		$productdata = ProductOrder::getAllOrderBycustomerId($id);

		$iteamdat=array();

		foreach($productdata as $pdata)
		{
			$iteamdat = OrderItems::getAlliteamsByemployeeId($pdata->id);
			$pdata->iteamdetail=$iteamdat;

		}

		if(count($productdata) != 0){
			return response(['status'=>"1","error_msg"=>"","data"=>$productdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}

	/*Get Announcement*/
	public function getAnnouncement(Request $request){


		$productdata = Announcement::getAllAnnouncement();

		if(count($productdata) != 0){
			return response(['status'=>"1","error_msg"=>"","data"=>$productdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	/*Insert Note*/
	public function addNotes(Request $request){

		$employee_id = Input::get('employee_id');
		$customer_id = Input::get('customer_id');
		$note = Input::get('note');
		$login_id = Input::get('login_id');



		if($note && $employee_id && $customer_id)
		{


				$data_array = array(
					'employee_id' => $employee_id,
					'customer_id' => $customer_id,
					'note'=>$note,
					'created_date' => date('Y-m-d H:i:s'),
					'created_by' => $login_id
				);

				$insert = new NoteMaster($data_array);
				$insert->save();
				$update = $insert->id;
				return response(['status'=>"1","error_msg"=>"Note inserted successfully","data"=>""]);


		}
		else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}

	/*Get Notes*/
	public function getNotes(Request $request){


		$notedata = NoteMaster::getAllrecord();

		if(count($notedata) != 0){
			return response(['status'=>"1","error_msg"=>"","data"=>$notedata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	public function addEmployee(Request $request){

		$name = Input::post('name');
		$date_of_birth = Input::post('date_of_birth');
		$city = Input::post('city');
		$address = Input::post('address');
		$posal_code = Input::post('post_code');
		$email_id = Input::post('email_id');
		$password = Input::post('password');
		$contact = Input::post('contact');
		$image = $request->file('image');
		$notes = Input::post('notes');



		if($name && $date_of_birth && $city && $address && $posal_code && $email_id && $password && $contact && $image)
		{
			$exitemail=AdminEmployeeMaster::checkExitEmail($email_id);

			if($exitemail == 1)
			{
				return response(['status'=>"0","error_msg"=>"Email is already exits.","data"=>""]);
			}
			else
			{
			/**************Start check old password or not *****************/
			$slug =SlugHelper::slug(Input::post('name'),'mf_employee_master', $field = 'slug', $key = NULL, $value = NULL);
				 /* $employee_code = AdminEmployeeMaster::checkEmployeeCode(Input::post('employee_code')); */

				$employee_code = AdminEmployeeMaster::lastEmployeeCode();

				if($employee_code)
				{
					$code = $employee_code->id + 1;
					$nemployee_code = '000'.$code;
				}
				else
				{
					$nemployee_code= 0001;
				}

				if($request->file('image') !=''){
                    $image = $request->file('image');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/employee');
                    $image->move($destinationPath, $photo);
                }
                $data_array = array(
				    'employee_code' => $nemployee_code,
                    'name' => $name,
                    'date_of_birth' => $date_of_birth,
                    'city' => $city,
					'address'=> $address,
					'posal_code'=> $posal_code,
					'email_id'=>$email_id,
					'password'=>md5($password),
					'contact'=>$contact,
					'image' => $photo,
					'notes'=>$notes,
                    'slug' => $slug,
                    'created_date' => date('Y-m-d H:i:s')

                );
                $insert = new AdminEmployeeMaster($data_array);
                $insert->save();
                $update = $insert->id;
				return response(['status'=>"1","error_msg"=>"Employee inserted successfully","data"=>""]);

			}
		}
		else{
			return response(['status'=>"0","error_msg"=>"Please provide all parameters.","data"=>""]);
		}
	}
/********Start get Product List by Employee Id**********************/
	public function getProductListByEmployeeId(Request $request){
		 $employee_id=Input::get('employee_id');
		 $type=0;
		$productdata = AdminProductMaster::productList();
		if(count($productdata) != 0){
			foreach ($productdata as $data) {
				 $available_employee_stock=EmployeeStockLog::getRecordByEmployeeProductId($data->id,$type,$employee_id);
				$data['defaultCartquntity'] = 1;
				if($available_employee_stock)
				{
			      $data->available_stock = $available_employee_stock->total_quantity;
				//$data['available_stock'] = $available_stock->available_stock;
				}
				else{
					  $data->available_stock = 0;
				//	$data['available_stock'] = 0;
				}
			}
			return response(['status'=>"1","error_msg"=>"","data"=>$productdata]);
		}else{
			return response(['status'=>"0","error_msg"=>"No data available!","data"=>""]);
		}
	}
	/********End get Product List  by Employee Id**********************/


}
