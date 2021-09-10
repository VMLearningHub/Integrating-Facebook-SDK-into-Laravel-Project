<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name'=> 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            $arr = ['status' =>400, "msg" => $validator->errors()->first(), 'result'=>[]];
        }else {
            try {
                $user = User::find(Auth::id());
                $user->name = $request->name;
                $user->save();
                $msg ='profile update successfully';
                $arr = array("status" => 200, "msg" => $msg );
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2]))
                {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg,"result" => array() );
            }
        }
        return \Response::json($arr);
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->scopes([
            "public_profile, pages_show_list", "pages_read_engagement", "pages_manage_posts", "pages_manage_metadata", "user_videos", "user_posts"
        ])->redirect();
    }

    public function handleProviderFacebookCallback()
    {
        $auth_user = Socialite::driver('facebook')->user();
        
        DB::table('users')
              ->where('id', Auth::id())
              ->update([
                'token' => $auth_user->token,
                'facebook_app_id'  =>  $auth_user->id,
              ]);
        return redirect()->to('/profile');
    }

    public function facebook_page_id(Request $request)
    {
        $input = $request->all();
        $rules = [
            'facebook_page_id'=> 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            $arr = ['status' =>400, "msg" => $validator->errors()->first(), 'result'=>[]];
        }else {
            try {
                $user = User::find(Auth::id());
                $user->facebook_page_id = $request->facebook_page_id;
                $user->save();
                $msg ='page id update successfully';
                $arr = array("status" => 200, "msg" => $msg );
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2]))
                {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg,"result" => array() );
            }
        }
        return \Response::json($arr);
        
    }

}
