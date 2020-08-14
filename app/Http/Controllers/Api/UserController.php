<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
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
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'f_name' => 'required',
            'sexe' => 'required',
            'email' => 'required|email',
            'naissance' => 'required',
            'phone' => 'required',
            'ville' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|min:8',
        ]);

        if($v->fails()) return response()->json($v->errors(), 500);
        if($request->password != $request->c_password) return response()->json(['error' => 'Erreur de confirmation de mot de passe'], 500);
        if(User::where(['email' => $request->email])->first()) return response()->json(['error' => 'email exist'], 500);
        if(User::where(['username' => $request->username])->first()) return response()->json(['error' => 'username exist'], 500);
        $user = new User();
            $user->code = User::getCode();
            $user->name = $request->name;
            $user->f_name = $request->f_name;
            $user->sexe = $request->sexe;
            $user->email = $request->email;
            $user->naissance = $request->naissance;
            $user->phone = $request->phone;
            $user->ville_id = $request->ville;
            $user->username = $request->username;
            $user->password = md5($request->password);
            $user->is_actived = 0;

            if($request->adresse) $user->adresse = $request->adresse;

            $user->save();

        return response()->json(new UserResource($user), 201);
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
