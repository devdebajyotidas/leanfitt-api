<?php

namespace App\Http\Controllers\API;

use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\SignupMail;
use App\Mail\PasswordResetMail;

class UserController extends Controller
{

    function login(Request $request){
        $response=new \stdClass();
        $device_id=$request->get('device_id');
        $fcm_token=$request->get('fcm_token');

        if($request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], true))
        {
            $user = Auth::user();
            if($user){

                unset($user['password'],$user['api_token'],$user['verification_token'],$user['deleted_at']);

                if(!empty($device_id) && !empty($fcm_token)){
                    $device=UserLog::where('device_id',$device_id)->first();
                    if($device){
                        $device->fcm_token=$fcm_token;
                        $device->update();
                    }
                    else{
                        $log['fcm_token']=$fcm_token;
                        $log['device_id']=$device_id;
                        $log['account_id']=$user->id;
                        UserLog::create($log);
                    }
                }

                $response->success=true;
                $response->data=$user;
                $response->message='Account found';
            }
            else{
                $response->success=false;
                $response->data=null;
                $response->message='Unable to login';
            }
        }
        else
        {
            $response->success=false;
            $response->data=null;
            $response->message='Incorrect email and password combination';
        }

        return response()->json($response);
    }

    function signup(Request $request){
        $response=new \stdClass();
        $mobile=isset($request->mobile) ? $request->mobile : '';
        $fcm_token=isset($request->fcm_token) ? $request->fcm_token : '';
        $device_id=isset($request->device_id) ? $request->device_id : '';

        $validator =  Validator::make($request->all(),User::$rules['create']);
        if($validator->passes()){
           if(!empty($mobile)){
               $exist=User::where('email',$request->email)->orWhere('mobile',$mobile)->count();
           }
           else{
               $exist=User::where('email',$request->email)->count();
           }

           if($exist > 0){
               $response->success=false;
               $response->message="Account already exist";
               return response()->json($response);
           }

           DB::beginTransaction();
           $data=$request->all();
           $data['account_level']=2;
           $data['verification_token']=md5(time());
           $user=User::create($data);

           if($user){

               if(!empty($fcm_token) && !empty($device_id)){
                  $log['fcm_token']=$fcm_token;
                  $log['device_id']=$device_id;
                  $log['account_id']=$user->id;
                  UserLog::create($log);
               }

               Mail::to($request->email)->send(new signupmail($request->all()));

               DB::commit();
               $response->success=true;
               $response->message="Account has been created";
           }
           else{
               DB::abort();
               $response->success=false;
               $response->message="Unable to create your account";
           }

        }
        else{
            $response->success=false;
            $response->message=$validator->errors()->first();
        }

        return response()->json($response);
    }

    /*Design database for password reste with a session token*/

    function recovery(Request $request){
        $response=new \stdClass();
        $email=$request->get('email');
        $mobile=$request->get('mobile');

        if(empty($email) && !empty($mobile)){
            $user=User::where('mobile',$mobile)->first();
            $email=$user->email;
        }

        if(empty($email)){
            $response->success=false;
            $response->message='Unable to find your account';
            return response()->json($response);
        }

        $token=$email['token']=random_int(111111,999999);
        $reset['token']=md5($token);
        $reset['email']=$email;
        $email['user_id']=isset($user->id) ? $user->id : '';

        PasswordReset::create($reset);

        Mail::to($email)->send(new PasswordResetMail($email));

        if(Mail::failures()){
            $response->success=false;
            $response->message="Unable to sent the otp try again";
        }
        else{
            $response->success=true;
            $response->message="An otp has been sent";
        }

    }

    function resetPassword(Request $request){
         $response=new \stdClass();
         $otp=$request->get('otp');

         if(empty($otp)){
             $response->success=false;
             $response->message="Please enter a valid otp";
             return response()->json($response);
         }

//         $verified=PasswordReset::

    }

    function verifyEmail(){

    }

}
