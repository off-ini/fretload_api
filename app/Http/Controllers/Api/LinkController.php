<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Link;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = Link::where(['code' => $code, 'is_used' => false])->first();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new LinkResource($data), 200);
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
        $v = Validator::make($request->all(), [
            'role' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
            $data = Link::find($id);
            if(is_null($data))
                return response()->json(['error' => 'Resource introuvable'], 404);
            else{
                    $user = User::find($request->user_id);
                    if($request->code)
                    {
                        $u_p = User::where(['code' => $request->code])->first();
                        if(!$u_p) return response()->json(['error' => 'Code parent introuvable'], 400);
                    }

                    DB::beginTransaction();
                        $user->roles()->sync($request->role);
                        if($request->code)
                        {
                            $user->update([
                                'code_parent' => $u_p->code,
                                'user_chauffeur_id' => $u_p->id,
                            ]);
                        }

                        $user->update([
                            'is_actived' => true,
                        ]);

                        $data->update([
                            'is_used' => true
                        ]);
                    DB::commit();

                return response()->json(new LinkResource($data), 201);
            }
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
