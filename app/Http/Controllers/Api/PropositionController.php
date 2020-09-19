<?php

namespace App\Http\Controllers\Api;

use App\Annonce;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropositionResource;
use App\Http\Resources\PropositionShowResource;
use App\Notifications\PropositionAcceptNotification;
use App\Notifications\PropositionNotification;
use App\Proposition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
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
            $data = [];
            $annoces = Annonce::where(['user_id' => $user->id]);

            foreach($annoces as $annoce)
            {
                $data[] = $annoce->ps;
            }

            $data = new Proposition($data);

            return PropositionResource::collection($data->where(['status' => true])->orderBy('created_at', 'DESC')->paginate(6));
        }else if($role->id >= 3)
        {
            return PropositionResource::collection(Proposition::where(['user_id' => $user->id, 'status' => true, 'is_mission' => false])->orderBy('created_at', 'DESC')->paginate(6));
        }

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
            'montant_t' => 'required',
            'annonce_id' => 'required',
            'user_id' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Proposition();
            $data->montant = $request->montant;
            $data->annonce_id = $request->annonce_id;
            $data->user_id = $request->user_id;

            $data->status = $request->status ? $request->status : false;
            $data->is_read = $request->is_read ? $request->is_read : false;
            $data->accepted_at = $request->accepted_at ? $request->accepted_at : null;

            $data->save();

        return response()->json(new PropositionResource($data), 201);
    }

    public function accept($id)
    {
        $data = Proposition::find($id);
        if($data->is_accept)
        {
            $data->update([
                'is_accept' => false,
                'accepted_at' => null,
            ]);
        }else{
            $data->update([
                'is_accept' => true,
                'accepted_at' => now(),
            ]);
            $user = $data->user;

            try{
                $user->notify(new PropositionAcceptNotification(new PropositionResource($data)));
                $this->notification($user);
            }catch(Exception $e){}
        }
        return response()->json(new PropositionResource($data), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Proposition::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new PropositionShowResource($data), 200);
    }

    public function showByAnnonceAndUser($annonce_id, $user_id)
    {
        $data = Proposition::where(['annonce_id' => $annonce_id, 'user_id' => $user_id])->first();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new PropositionResource($data), 200);
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
    public function update(Request $request, $annonce_id, $user_id)
    {
        $data = Proposition::where(['annonce_id' => $annonce_id, 'user_id' => $user_id])->first();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {

            $data->update([
                'montant' => $request->montant ? $request->montant : $data->montant,
                'annonce_id' => $request->annonce_id ? $request->annonce_id  : $data->annonce_id,
                'user_id' => $request->user_id ? $request->user_id : $data->user_id,
                'status' => $request->status ? $request->status : $data->status,
                'is_read' => $request->is_read ? $request->is_read : $data->is_read,
                'accepted_at' => $request->accepted_at ? $request->accepted_at : $data->accepted_at,
            ]);

            if($request->vehicule_ids)
            {
                $data->vehicules()->sync($request->vehicule_ids);
            }

            $user = Annonce::find($annonce_id)->user;

            try{
                $user->notify(new PropositionNotification(new PropositionResource($data)));
                $this->notification($user);
            }catch(Exception $e){}

            return response()->json(new PropositionResource($data), 200);
        }
    }

    public function notification($user)
    {
        $notifications = $user->unreadNotifications()->first();
        event(new NotificationEvent(['user_id' => $user->id, 'data' => $notifications]));
        return $notifications;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Proposition::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->delete();
            return response()->json(new PropositionResource($data), 200);
        }
    }
}
