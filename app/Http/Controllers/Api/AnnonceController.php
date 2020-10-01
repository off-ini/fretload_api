<?php

namespace App\Http\Controllers\Api;

use App\Annonce;
use App\Events\AnnonceEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnnonceResource;
use App\Marchandise;
use App\Proposition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles[0];

        if($role->id == 2)
        {
            $data = Annonce::where(['user_id' => $user->id]);
        }else if($role->id >= 3)
        {
            return AnnonceResource::collection(Annonce::orderBy('created_at', 'DESC')->paginate(6));
        }else{
            return AnnonceResource::collection(Annonce::orderBy('created_at', 'DESC')->paginate(6));
        }


        return AnnonceResource::collection($data->orderBy('created_at', 'DESC')->paginate(6));

    }

    public function all_news()
    {
        $user = Auth::user();
        $role = $user->roles[0];

        if($role->id >= 3)
        {
            $annonce_id_all = Proposition::where(['user_id' => $user->id])->select('annonce_id')->get()->toArray();
            $data_news = Annonce::whereNotIn('id',$annonce_id_all);

            foreach($data_news->get() as $item)
            {
                $item->propositions()->attach($user->id, ['is_read' => true]);
            }

            return AnnonceResource::collection($data_news->orderBy('created_at', 'DESC')->get());
        }
        return [];
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
            'marchandise_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
            $data = new Annonce();
            $data->code = Annonce::getCode();
            $data->marchandise_id = $request->marchandise_id;
            $data->user_id = $request->user_id;

            $data->title = $request->title ? $request->title : null;
            $data->montant = $request->montant ? $request->montant : null;
            $data->montant_k = $request->montant_k ? $request->montant_k : null;
            $data->body = $request->body ? $request->body : null;
            $data->payload = $request->payload ? $request->payload : null;
            $data->is_public = $request->is_public ? $request->is_public : true;
            $data->user_sigle_id = $request->user_sigle_id ? $request->user_sigle_id : null;

            DB::beginTransaction();
                $data->save();
                Marchandise::find($request->marchandise_id)->update(['status' => 1]);
            DB::commit();

            try{
                event(new AnnonceEvent(new AnnonceResource($data)));
            }catch(Exception $e){}

        return response()->json(new AnnonceResource($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Annonce::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new AnnonceResource($data), 200);
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
        $data = Annonce::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->update($request->all());

            return response()->json(new AnnonceResource($data), 200);
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
        $data = Annonce::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new AnnonceResource($data), 200);
        }
    }
}
