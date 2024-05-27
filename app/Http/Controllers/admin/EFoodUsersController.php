<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodUser;
use App\Models\Ordermaster;

class EFoodUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['firstName'] = $firstName = $request->firstName;
        $this->data['lastName'] = $lastName = $request->lastName;
        $this->data['email'] = $email = $request->email;
        $this->data['mobile'] = $mobile = $request->mobile;
        $this->data['list'] = FoodUser::getAllUsers($firstName, $lastName, $email, $mobile);
        $this->data['module'] = 'Food Users List';
        return view('admin.efood-users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = FoodUser::getUserById($id);
        $this->data['module'] = 'Food Users Show';
        $this->data['orders'] = Ordermaster::totalOrderOfUser($id);
        $this->data['totalAmount'] = Ordermaster::totalAmountByUser($id);
        return view('admin.efood-users.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
