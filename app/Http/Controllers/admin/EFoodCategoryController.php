<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foodmenucategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class EFoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rules()
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
            ],
        );
    }
    public function rules1($id)
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
            ],
        );
    }
    public function index(Request $request)
    {
        $this->data['module'] = 'Food Category List ';
        $this->data['categoryName'] = $categoryName = $request->categoryName;
        $this->data['list'] = Foodmenucategory::getCategory($categoryName);
        return view('admin.efood-category.index', $this->data);
    }


    public function create()
    {
        $this->data['module'] = 'Food Category Add ';
        return view('admin.efood-category.create', $this->data);
    }

    public function store(Request $request)
    {
        $createCategory = ([
            "name" => $request->name,
            "created_at" => now(),
            "created_by" => Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules());


        if ($validator->fails()) {
            return redirect('food-category/create')->withErrors($validator, "admin")->withInput();
        } else {

            $service = Foodmenucategory::createCategory($createCategory);

            if ($service) {
                Session::flash('success', 'Food Category ' . trans('messages.createdSuccessfully'));
                return redirect('food-category');
            } else {
                Session::flash('error', trans('messages.errormsg'));
                return redirect()->back();
            }
        }
    }
    public function show($id)
    {
    }

    public function edit($id)
    {
        $this->data['module'] = 'Food Category Edit ';
        $this->data['edit'] = Foodmenucategory::findCategory($id);
        return view('admin.efood-category.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $updateCategory = ([
            "name" => $request->name,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $service = Foodmenucategory::updateCategory($id, $updateCategory);

            if ($service) {
                Session::flash('success', 'Food Category ' . trans('messages.updatedSuccessfully'));
                return redirect('food-category');
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
        Foodmenucategory::updateCategory($id, $deleteArray);

        $teamMember = Foodmenucategory::deleteCategory($id);

        if ($teamMember) {
            Session::flash('success', 'Food Category ' . trans('messages.deletedSuccessfully'));
            return redirect('food-category');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}
