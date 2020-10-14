<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarchandiseResource;
use App\Http\Resources\MarchandiseSelectResource;
use App\Marchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MarchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return MarchandiseResource::collection(Marchandise::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
    }

    public function selected()
    {
        $user = Auth::user();
        return MarchandiseSelectResource::collection(Marchandise::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->get());
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
            'adresse_depart_id' => 'required',
            'adresse_arriver_id' => 'required',
            'destinataire_id' => 'required',
            'type_marchandise_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Marchandise();
            $data->libelle = $request->libelle;
            $data->adresse_depart_id = $request->adresse_depart_id;
            $data->adresse_arriver_id = $request->adresse_arriver_id;
            $data->destinataire_id = $request->destinataire_id;
            $data->type_marchandise_id = $request->type_marchandise_id;
            $data->user_id = $request->user_id;

            $data->description = $request->description ? $request->description : null;
            $data->poid = $request->poid ? $request->poid : null;
            $data->status = $request->status ? $request->status : 0;
            $data->volume = $request->volume ? $request->volume : null;
            $data->qte = $request->qte ? $request->qte : null;

            if($request->image)
            {
                $name = File::write($request->image);
                if($name)
                {
                    $data->image = $name;
                }
            }

            $data->save();

        return response()->json(new MarchandiseResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Marchandise::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new MarchandiseResource($data), 200);
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
        $data = Marchandise::find($id);
        $all = $request->all();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            if(isset($all['image']) && $all['image'])
            {
                $name = File::write($all['image']);
                if($name)
                {
                    $all['image'] = $name;
                }else $all['image'] = $data->image;
            }

            $data->update($all);

            return response()->json(new MarchandiseResource($data), 200);
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
        $data = Marchandise::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new MarchandiseResource($data), 200);
        }
    }
}
