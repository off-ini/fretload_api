<?php

namespace App\Http\Controllers\Api;

use App\Adresse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdresseResource;
use App\Http\Resources\AdresseSelectResource;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AdresseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return AdresseResource::collection(Adresse::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
    }

    public function selected()
    {
        $user = Auth::user();
        return AdresseSelectResource::collection(Adresse::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->get());
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
            'ville_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Adresse();
            $data->name = $request->name;
            $data->ville_id = $request->ville_id;
            $data->user_id = $request->user_id;

            $data->description = $request->description ? $request->description : null;
            $data->adresse = $request->adresse ? $request->adresse : null;
            $data->logitude = $request->logitude ? $request->logitude : null;
            $data->latitude = $request->latitude ? $request->latitude : null;

            $data->save();

        return response()->json(new AdresseResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Adresse::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new AdresseResource($data), 200);
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
        $data = Adresse::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->update($request->all());

            return response()->json(new AdresseResource($data), 200);
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
        $data = Adresse::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new AdresseResource($data), 200);
        }
    }
}
