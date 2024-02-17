<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;
use Auth;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /**Validate the data using validation rules
        */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
            
        /**Check the validation becomes fails or not
        */
        if ($validator->fails()) {
            /**Return error message
            */
            return response()->json([ 'error'=> $validator->errors() ]);
        }

        /**Store all values of the fields
        */
        $newuser = $request->all();

            /**Create an encrypted password using the hash
        */
        $newuser['password'] = Hash::make($newuser['password']);

        /**Insert a new user in the table
        */
        $user = User::create($newuser);

            /**Create an access token for the user
        */
        $success['token'] = $user->createToken('AppName')->accessToken;
        /**Return success message with token value
        */

        return response()->json(['status' => 'success', 'sms' => 'Create Successfully', 'token' => $success]);
    }

    public function login(Request $request){
        /**Read the credentials passed by the user
        */
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        /**Check the credentials are valid or not
        */
        if( auth()->attempt($credentials) ){
            /**Store the information of authenticated user
            */
            $user = Auth::user();
            /**Create token for the authenticated user
            */
            $success['token'] = $user->createToken('AppName')->accessToken;
            // return response()->json(['success' => $success]);

            return response()->json(['status' => 'success', 'sms' => 'login successfully', 'token' => $success['token']]);
        } else {
            /**Return error message
            */
            // return response()->json(['error'=>'Unauthorized']);
            return response()->json(['status' => 'error', 'sms' => 'user not found']);
        }

    }
    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();

        $response = ['status' => 'success','sms' => 'You have been successfully logged out!'];

        return response()->json($response, 200);
    }

    public function list(){
        try {
            $users = DB::table('users')->get();
            return response()->json(['status' => 'success', 'data' => $users]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'sms' => $e->getMessage()]);
        }
    }

    public function edit(Request $r){
        $user = DB::table('users')->find($r->user_id);

        return response()->json(['data' => $user]);
    }
    public function update(Request $r){
        try {
            $update = DB::table('users')->where('id',$r->user_id)->update(['name' => $r->name, 'email' => $r->email]);
            return response()->json(['status' => 'success', 'sms' => 'update successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'sms' => 'update unsuccessfully']);
        }
    }

    public function delete(Request $r){
        try {

            DB::table('users')->where('id',$r->user_id)->delete();
            
            return response()->json(['status' => 'success', 'sms' => 'delete successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error', 'sms' => 'delete unsuccessfully']);
        }
    }

}
