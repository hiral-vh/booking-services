<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EFoodCuisineController extends Controller
{
    public function rules()
    {
        return array_merge(
            [
                'cuisine_name'     => 'required|max:30',
            ],
        );
    }

    public function index(Request $request)
    {
        $this->data['module'] = 'Cuisine ' . 'List ';
        $this->data['cuisine_name'] = $request->cuisine_name;
        if(empty($request->name))
        {
            $this->data['cuisine'] = Cuisine::getCuisine();
        }else{
            $this->data['cuisine'] = Cuisine::getCuisineByName($request->name);
        }
        return view('admin.cuisine.index', $this->data);
    }


    public function create()
    {
        $this->data['module'] = 'Cuisine ' . 'Add ';
        return view('admin.cuisine.create', $this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $createCuisine = ([
                "cuisine_name" => $request->cuisine_name,
            ]);

            $cuisine = Cuisine::createCuisine($createCuisine);

            if (isset($cuisine)) {
                Session::flash('success', 'Cuisine ' . trans('messages.createdSuccessfully'));
                return redirect()->route('cuisine.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function edit($id)
    {
        $this->data['module'] = 'Cuisine ' . 'Edit ';
        $this->data['cuisine'] = Cuisine::findCuisine($id);
        return view('admin.cuisine.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $updateCuisine = ([
                "cuisine_name" => $request->cuisine_name,
            ]);

            $cuisine = Cuisine::updateCuisine($id,$updateCuisine);

            if (isset($cuisine)) {
                Session::flash('success', 'Cuisine ' . trans('messages.updatedSuccessfully'));
                return redirect()->route('cuisine.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function destroy($id)
    {
        $cuisine = Cuisine::deleteCuisine($id);

        if (isset($cuisine)) {
            Session::flash('success', 'Cuisine ' . trans('messages.deletedSuccessfully'));
            return redirect()->route('cuisine.index');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}
