<?php

namespace App\Http\Controllers\Api;

use App\Destinataire;
use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinataireResource;
use App\Http\Resources\DestinataireSelectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DestinataireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DestinataireResource::collection(Destinataire::where(['user_id' => Auth::user()->id])->paginate(8));
    }

    public function selected()
    {
        return DestinataireSelectResource::collection(Destinataire::where(['user_id' => Auth::user()->id])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return dd($request->all());
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'f_name' => 'required',
            'sexe' => 'required',
            'email' => 'required|email',
            'naissance' => 'required',
            'phone' => 'required',
            'ville_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        if(Destinataire::where(['email' => $request->email])->first()) return response()->json(['error' => 'email exist'], 400);
        $data = new Destinataire();
            $data->name = $request->name;
            $data->f_name = $request->f_name;
            $data->sexe = $request->sexe;
            $data->email = $request->email;
            $data->naissance = $request->naissance;
            $data->phone = $request->phone;
            $data->ville_id = $request->ville_id;
            $data->user_id = $request->user_id;

            if($request->adresse) $data->adresse = $request->adresse;

            if($request->photo)
            {
                $name = File::write($request->photo);
                if($name)
                {
                    $data->photo = $name;
                }
            }

            $data->save();

        return response()->json(new DestinataireResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Destinataire::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new DestinataireResource($data), 200);
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
        $data = Destinataire::find($id);
        $all = $request->all();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            /*$request->name ? $data->name = $request->name : null;
            $request->f_name ? $data->f_name = $request->f_name : null;
            $request->sexe ? $data->sexe = $request->sexe : null;
            $request->email ? $data->email = $request->email : null;
            $request->naissance ? $data->naissance = $request->naissance : null;
            $request->adresse ? $data->adresse = $request->adresse : null;
            $request->phone ? $data->phone = $request->phone : null;
            $request->ville_id ? $data->ville_id = $request->ville_id : null;
            $request->user_id? $data->user_id = $request->user_id : null;*/

            if(isset($all['photo']) && $all['photo'])
            {
                $name = File::write($all['photo']);
                if($name)
                {
                    $all['photo'] = $name;
                }else $all['photo'] = $data->photo;
            }

            $data->update($all);

            return response()->json(new DestinataireResource($data), 200);
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
        $data = Destinataire::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new DestinataireResource($data), 200);
        }
    }
}
