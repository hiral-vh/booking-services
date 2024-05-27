<?php

namespace App\Http\Controllers\admin;

use App\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EFoodTypeController extends Controller
{
    use ImageUploadTrait;

    public function rules()
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'image'    => 'required|mimes:jpeg,jpg,png,svg',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'image'    => 'mimes:jpeg,jpg,png,svg',
            ],
        );
    }
    public function index(Request $request)
    {
        $this->data['module'] = 'Food Category ' . 'List ';
        $this->data['name'] = $request->name;
        if(empty($request->name))
        {
            $this->data['foodType'] = FoodType::getFoodType();
        }else{
            $this->data['foodType'] = FoodType::getFoodTypeByName($request->name);
        }
        return view('admin.food-type.index', $this->data);
    }


    public function create()
    {
        $this->data['module'] = 'Food Category ' . 'Add ';
        return view('admin.food-type.create', $this->data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $createFoodType = ([
                "food_category_name" => $request->name,
                "created_at" => now(),
                "created_by" => Auth::guard('admin')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadFullUrlImage($file,'/upload/food_category/');
            }

            if($file_name != ''){
                $createFoodType['food_category_image'] = $file_name;
            }
            $foodType = FoodType::createFoodType($createFoodType);

            if (isset($foodType)) {
                Session::flash('success', 'Food Category ' . trans('messages.createdSuccessfully'));
                return redirect()->route('food-type.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function edit($id)
    {
        $this->data['module'] = 'Food Category ' . 'Edit ';
        $this->data['foodType'] = FoodType::findFoodType($id);
        return view('admin.food-type.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {
            $updateFoodType = ([
                "food_category_name" => $request->name,
                "updated_at" => now(),
                "updated_by" => Auth::guard('admin')->user()->id,
            ]);

            $file_name = '';
            if ($request->hasFile('image') ) {
                $file = $request->file('image');
                $file_name=$this->uploadImage($file,'upload/food_category/');
            }

            if($file_name != ''){
                $updateFoodType['food_category_image'] = $file_name;
            }

            $foodType = FoodType::updateFoodType($id,$updateFoodType);


            if (isset($foodType)) {
                Session::flash('success', 'Food Category ' . trans('messages.updatedSuccessfully'));
                return redirect()->route('food-type.index');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }

    public function destroy($id)
    {
        $deleteArray = ([
            "deleted_by" => Auth::guard('admin')->user()->id,
        ]);
        FoodType::updateFoodType($id, $deleteArray);

        $foodType = FoodType::deleteFoodType($id);

        if (isset($foodType)) {
            Session::flash('success', 'Food Category ' . trans('messages.deletedSuccessfully'));
            return redirect()->route('food-type.index');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}
