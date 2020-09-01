<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MissionResource;
use App\Mission;
use App\Proposition;
use App\User;
use App\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return MissionResource::collection(Mission::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
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
            'title' => 'required',
            'montant' => 'required',
            'date_depart_pre' => 'required',
            'date_arriver_pre' => 'required',
            'marchandise_id' => 'required',
            'destinataire_id' => 'required',
            'proposition_id' => 'required',
            'user_id' => 'required',
            'chauffeur_ids' => 'required',
            'vehicule_ids' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Mission();
            $data->title = $request->title;
            $data->montant = $request->montant;
            $data->date_depart_pre = date("Y-m-d", strtotime($request->date_depart_pre));
            $data->date_arriver_pre = date("Y-m-d", strtotime($request->date_arriver_pre));
            $data->marchandise_id = $request->marchandise_id;
            $data->destinataire_id = $request->destinataire_id;
            $data->proposition_id = $request->proposition_id;
            $data->user_id = $request->user_id;

            $data->date_depart_eff = $request->date_depart_eff ? $request->date_depart_eff : null;
            $data->date_arriver_eff = $request->date_arriver_eff ? $request->date_arriver_eff : null;
            $data->status = 0;
            $data->user_p_id = $request->user_p_id ? $request->user_p_id : null;

            DB::beginTransaction();
                $data->save();
                $data->vehicules()->sync($request->vehicule_ids);
                $data->chauffeurs()->sync($request->chauffeur_ids);
                Vehicule::whereIn('id', $request->vehicule_ids)->update(['status' => 1]);
                User::whereIn('id', $request->chauffeur_ids)->update(['status' => 1]);
                Proposition::find($request->proposition_id)->update(['is_mission' => true]);
            DB::commit();

        return response()->json(new MissionResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Mission::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new MissionResource($data), 200);
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
        $data = Mission::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            DB::beginTransaction();
                $data->update([
                    'title' => $request->title,
                    'montant' => $request->montant,
                    'date_depart_pre' => date("Y-m-d", strtotime($request->date_depart_pre)),
                    'date_arriver_pre' => date("Y-m-d", strtotime($request->date_arriver_pre)),
                    'marchandise_id' => $request->marchandise_id,
                    'destinataire_id' => $request->destinataire_id,
                    'proposition_id' => $request->proposition_id,
                    'user_id' => $request->user_id,
                    'description' => $request->description ? $request->description : $data->description,
                ]);
                $data->vehicules()->sync($request->vehicule_ids);
                $data->chauffeurs()->sync($request->chauffeur_ids);
            DB::commit();

            return response()->json(new MissionResource($data), 200);
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
        $data = Mission::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new MissionResource($data), 200);
        }
    }
}
