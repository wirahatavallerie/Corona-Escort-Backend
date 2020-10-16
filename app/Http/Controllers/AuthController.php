<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'   => $validator->errors()->first(),
                'status'    => 0
            ], 401);
        }else{
            $user = User::where('username','=', $request->username)->first();
            if($user){
                if($user->password === md5($request->password)){
                    $user->generateToken();
                    $data = new UserResource($user);
                    return response()->json([
                        'message' => "Login berhasil",
                        'status' => 1,
                        'data' => $data,
                    ], 200);
                }else{ 
                    return response()->json([
                        'message' => "Password salah",
                        'status' => 0
                    ], 401);
                }
            }else{
                return response()->json([
                    'message' => "Username tidak ditemukan",
                    'status' => 0,
                ], 401);
            }
        }
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3|max:20',
            'username'  => 'required|min:4|max:25|unique:users',
            'password'  => 'required|min:5|max:12'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'   => $validator->errors()->first(),
                'status'    => 0
            ], 401);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'username'  => $request->username,
                'password'  => md5($request->password)
            ]);
            if($user){
                $user->generateToken();
                $data = new UserResource($user);
                return response()->json([
                    'message'   => 'Register berhasil',
                    'status'    => 1,
                    'data'      => $data
                ], 200);
            }else{
                return response()->json([
                    'message'   => 'Register gagal',
                    'status'    => 0
                ], 401);
            }
        }

    }
    public function logout(){
        $user = Auth::user();
        if($user){
            $user->api_token = null;
            if($user->save()){
                return response()->json([
                    'message'   => 'Logout berhasil'
                ], 200);
            }
        }else{
            return response()->json([
                'message'   =>'Logout gagal'
            ],401);
        }
    }

    public function test(Request $request){
        $username = $request->username;
        $password = $request->password;
        return response()->json([
            'username'=> $username,
            'password' => $password,
        ]);
    }
}
