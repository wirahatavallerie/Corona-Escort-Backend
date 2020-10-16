<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User as UserResource;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if(Auth::user()){
            return response()->json([
                'message'   => 'profile berhasil ditampilkan',
                'status'    => 1,
                'data'      => new UserResource($user),
            ], 200);
        }else{
            return response()->json([
                'message'   => 'profile user gagal ditampilkan',
                'status'    => 0,
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if(Auth::user()){
            $validator = Validator::make($request->all(),[
                'name'      => 'required|min:3|max:30',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message'   => $validator->errors()->first(),
                    'status'    => 0
                ], 401);
            }else{
                $user->name = $request->name;
                if($user->save()){
                    return response()->json([
                        'message'   => 'Profile berhasil diubah',
                        'status'    => 1,
                        'data'      => new UserResource($user)
                    ], 200);
                }else{
                    return response()->json([
                        'message'   => 'Gagal mengubah profile',
                        'status'    => 0
                    ], 401);
                }
                
            }
        }else{
            return response()->json([
                'message'   => 'unauthorized',
                'status'    => 0
            ], 401);
        }
    }

    public function storePass(Request $request)
    {
        $user = Auth::user();
        if(Auth::user()){
            $validator = Validator::make($request->all(),[
                'password'      => 'required',
                'newPassword'   => 'required|min:3|max:30',
                'repeatPassword'=> 'required'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message'   => $validator->errors()->first(),
                    'status'    => 0
                ], 401);
            }else{
                if($user->password === md5($request->password)){
                    if($request->newPassword === $request->repeatPassword){
                        $user->password = md5($request->newPassword);
                        if($user->save()){
                            return response()->json([
                                'message'   => 'Password berhasil diubah',
                                'status'    => 1,
                                'data'      => new UserResource($user)
                            ], 200);
                        }else{
                            return response()->json([
                                'message'   => 'Gagal mengubah password',
                                'status'    => 0
                            ], 422);
                        }
                    }else{
                        return response()->json([
                            'message'   => 'Password berbeda',
                            'status'    => 0
                        ], 422);
                    }
                }else{
                    return response()->json([
                        'message'   => 'Password tidak benar',
                        'status'    => 0
                    ], 422);
                }                
            }
        }else{
            return response()->json([
                'message'   => 'unauthorized',
                'status'    => 0
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
