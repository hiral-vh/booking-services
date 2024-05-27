<?php

namespace App\Http\Controllers\business;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BusinessSetTokenController extends Controller
{
    public function index()
    {
        $data['module'] = 'Business Profile ' . 'Details ';
        return view('settoken', $data);
    }
}
