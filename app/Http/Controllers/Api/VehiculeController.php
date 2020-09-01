<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehiculeResource;
use App\Vehicule;
use Illuminate\Http\Request;
use Validator;
use Auth;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return VehiculeResource::collection(Vehicule::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
    }

    public function libre()
    {
        $user = Auth::user();
        return VehiculeResource::collection(Vehicule::where(['user_id' => $user->id, 'status' => 0])->orderBy('created_at', 'DESC')->get());
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
            'matricule' => 'required',
            'type_vehicule_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Vehicule();
            $data->matricule = $request->matricule;
            $data->type_vehicule_id = $request->type_vehicule_id;
            $data->user_id = $request->user_id;

            $data->libelle = $request->libelle ? $request->libelle : null;
            $data->description = $request->description ? $request->description : null;
            $data->capacite = $request->capacite ? $request->capacite : null;
            $data->taille = $request->taille ? $request->taille : null;

            if($request->image)
            {
                $name = File::write($request->image);
                if($name)
                {
                    $data->image = $name;
                }
            }

            $data->save();

        return response()->json(new VehiculeResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Vehicule::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new VehiculeResource($data), 200);
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
        $data = Vehicule::find($id);
        $all = $request->all();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            if($all['image'])
            {
                $name = File::write($all['image']);
                if($name)
                {
                    $all['image'] = $name;
                }else $all['image'] = $data->image;
            }
            $data->update($all);

            return response()->json(new VehiculeResource($data), 200);
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
        $data = vehicule::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new VehiculeResource($data), 200);
        }
    }
}
