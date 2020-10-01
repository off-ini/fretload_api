<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeMarchandiseResource;
use App\Http\Resources\TypeMarchandiseSelectResource;
use App\TypeMarchandise;
use Illuminate\Http\Request;
use Validator;

class TypeMarchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TypeMarchandiseResource::collection(TypeMarchandise::orderBy('libelle')->paginate(6));
    }

    public function selected()
    {
        return TypeMarchandiseSelectResource::collection(TypeMarchandise::orderBy('libelle')->get());
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
        $data = new TypeMarchandise();
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

        return response()->json(new TypeMarchandiseResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TypeMarchandise::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new TypeMarchandiseResource($data), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $data = TypeMarchandise::find($id);
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

            return response()->json(new TypeMarchandiseResource($data), 200);
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
        $data = TypeMarchandise::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new TypeMarchandiseResource($data), 200);
        }
    }
}
