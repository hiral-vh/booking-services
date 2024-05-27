<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Foodmenucategory;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\Foodmenusubcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;

class EFoodSubCategoryController extends Controller
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
                'category_id' => 'required',
            ],
        );
    }
    public function rules1()
    {
        return array_merge(
            [
                'name'     => 'required|max:30',
                'category_id' => 'required',
            ],
        );
    }
    public function index(Request $request)
    {
        $this->data['module'] = 'Food Sub Category List ';
        $this->data['categoryName'] = $categoryName = $request->categoryName;
        $this->data['subCategoryName'] = $subCategoryName = $request->subCategoryName;
        $this->data['list'] = Foodmenusubcategory::getCategory($categoryName, $subCategoryName);

        return view('admin.efood-sub-category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['module'] = 'Food Sub Category Add ';
        $this->data['category'] = Foodmenucategory::listCategory();
        return view('admin.efood-sub-category.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $createCategory = ([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "created_at" => now(),
            "created_by" => Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules());


        if ($validator->fails()) {
            return redirect('food-category/create')->withErrors($validator, "admin")->withInput();
        } else {
            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/sub-category/');
            }

            if ($file_name != '') {
                $createCategory['image'] = $file_name;
            }
            $service = Foodmenusubcategory::createSubCategory($createCategory);

            if ($service) {
                Session::flash('success', 'Food Sub Category ' . trans('messages.createdSuccessfully'));
                return redirect('food-sub-category');
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
        $this->data['module'] = 'Food Sub Category Edit';
        $this->data['category'] = Foodmenucategory::listCategory();
        $this->data['edit'] = Foodmenusubcategory::findSubCategory($id);
        return view('admin.efood-sub-category.edit', $this->data);
    }

    public function update(Request $request, $id)
    {
        $updateCategory = ([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "updated_at" => now(),
            "updated_by" => Auth::guard('admin')->user()->id,
        ]);

        $validator = Validator::make($request->all(), $this->rules1($id));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, "admin")->withInput();
        } else {

            $file_name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = FileUploadTrait::image_upload($file, 'assets/images/sub-category/');
            }

            if ($file_name != '') {
                $updateCategory['image'] = $file_name;
            }

            $service = Foodmenusubcategory::updateSubCategory($id, $updateCategory);

            if ($service) {
                Session::flash('success', 'Food Sub Category ' . trans('messages.updatedSuccessfully'));
                return redirect('food-sub-category');
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
        Foodmenusubcategory::updateSubCategory($id, $deleteArray);

        $teamMember = Foodmenusubcategory::deleteSubCategory($id);

        if ($teamMember) {
            Session::flash('success', 'Food Sub Category ' . trans('messages.deletedSuccessfully'));
            return redirect('food-sub-category');
        } else {
            Session::flash('error', trans('messages.errormsg'));
            return redirect()->back();
        }
    }
}
