<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeVehiculeResource;
use App\Http\Resources\TypeVehiculeSelectResource;
use App\TypeVehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeVehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TypeVehiculeResource::collection(TypeVehicule::orderBy('libelle')->paginate(6));
    }

    public function selected()
    {
        return TypeVehiculeSelectResource::collection(TypeVehicule::orderBy('libelle')->get());
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
            'libelle' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new TypeVehicule();
            $data->libelle = $request->libelle;
            if($request->default_image)
            {
                $name = File::write($request->default_image);
                if($name)
                {
                    $data->default_image = $name;
                }
            }

            $data->save();

        return response()->json(new TypeVehiculeResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TypeVehicule::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new TypeVehiculeResource($data), 200);
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
        $data = TypeVehicule::find($id);
        $all = $request->all();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            if($all['default_image'])
            {
                $name = File::write($all['default_image']);
                if($name)
                {
                    $all['default_image']=$name;
                }else $all['default_image'] = $data->default_image;
            }
            $data->update($all);

            return response()->json(new TypeVehiculeResource($data), 200);
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
        $data = TypeVehicule::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new TypeVehiculeResource($data), 200);
        }
    }
}
