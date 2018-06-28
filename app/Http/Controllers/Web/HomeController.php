<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function verification(Request $request){
        if(!empty($request->get('token'))){
            $user=User::where('verification_token',$request->get('token'))->first();
            if($user){
                $user->is_verified=1;
                if($user->update()){
                    exit('Account verified');
                }
                else{
                    exit('Unable to verify the account');
                }
            }
            else{
                exit('Account not found');
            }
        }else{
            exit('Token not found');
        }
    }
}
