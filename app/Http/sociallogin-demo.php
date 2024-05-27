public function socialLogin(Request $request){

            if (!empty($getUser)) {
                $user =  Auth::guard('web')->user();
                $loginId = $getUser->id;
                $userArray = [
                    "id"            => $getUser->id,
                    "first_name"    => $getUser->first_name,
                    "last_name"     => $getUser->last_name,
                    "email"         => $getUser->email,
                    "mobile"        => $getUser->mobile,
                    "profile_photo" => $getUser->profile_photo_path,
                    "status"        => $getUser->status,
                    "country_code"  => $getUser->country_code
                ];

                $userarray = array('token' => $getUser->createToken('MyApp')->plainTextToken);
                User::where('id', $getUser->id)->update($userarray);
                $user = User::find($getUser->id);
                return response()->json(['error_msg' => 'Login successfully.', 'status' => 1, 'data' => array($user)], $this->successStatus);
            } else {
                $userArray = [
                    'social_id' => request('social_id'),
                    'social_type' => request('social_type'),
                    'first_name' => request('first_name'),
                    'last_name' => request('last_name'),
                    'name' => request('first_name') . ' ' . request('last_name'),
                    'email' => request('email'),
                    'mobile' => request('mobile'),
                    'profile_photo' => request('profile_photo'),
                    'status' => request('status'),
                    'country_code' => request('country_code'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $save = User::createUser($userArray);
                $loginId = $save->id;
                $userArray['id'] = $loginId;
                $input = $request->all();
                $user = User::create($input);
                $user = User::find($getUser->id);
                $token = $user->createToken('MyApp')->accessToken;
                $userarray = array('token' => $token);
                $user['token'] = $token;
                User::where('id', $user->id)->update($userarray);

                if($user){
                    return response()->json(['error_msg' => 'Successfully Registered.', 'status' => 1, 'data' => array($user)], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
            $auth = Auth::guard('web')->loginUsingId($loginId);
            $token = $auth->createToken('MyApp')->plainTextToken;
            $userArray['token'] = $token;
            return response()->json(['error_msg' => 'Login successfully.', 'status' => 1, 'data' => array($userArray)], $this->successStatus);
        }
    }