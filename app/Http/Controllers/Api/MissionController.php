<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEvent;
use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\MissionResource;
use App\Marchandise;
use App\Mission;
use App\Notifications\MissionNotification;
use App\Proposition;
use App\User;
use App\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $role = $user->roles[0];

        if($role->id == 2)
        {
            return MissionResource::collection(Mission::where(['user_p_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
        }else if($role->id == 3)
        {
            return MissionResource::collection(Mission::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->paginate(6));
        }else if($role->id >= 4)
        {
            $data = Mission::whereHas('chauffeurs', function($query) use ($user){
                return $query->where('users.id',$user->id);
            })->orderBy('missions.created_at', 'DESC')->paginate(6);

            return MissionResource::collection($data);
        }
    }

    public function all()
    {
        $user = Auth::user();
        $role = $user->roles[0];

        if($role->id == 2)
        {
            return MissionResource::collection(Mission::where(['user_p_id' => $user->id])->orderBy('created_at', 'DESC')->get());
        }else if($role->id == 3)
        {
            return MissionResource::collection(Mission::where(['user_id' => $user->id])->orderBy('created_at', 'DESC')->get());
        }else if($role->id >= 4)
        {
            $data = Mission::whereHas('chauffeurs', function($query) use ($user){
                return $query->where('users.id',$user->id);
            })->orderBy('missions.created_at', 'DESC')->get();

            return MissionResource::collection($data);
        }
    }

    public function allCount()
    {
        $user = Auth::user();
        $role = $user->roles[0];

        $all = 0;
        $load = 0;
        $end = 0;
        $paided = 0;

        if($role->id == 2)
        {
            $all = Mission::where(['user_p_id' => $user->id])->get()->count();
            $load = Mission::where(['user_p_id' => $user->id, 'status' => 1])->get()->count();
            $end = Mission::where(['user_p_id' => $user->id, 'status' => 2])->get()->count();
            $paided = Mission::where(['user_p_id' => $user->id, 'status' => 3])->get()->count();

        }else if($role->id == 3)
        {
            $all = Mission::where(['user_id' => $user->id])->get()->count();
            $load = Mission::where(['user_id' => $user->id, 'status' => 1])->get()->count();
            $end = Mission::where(['user_id' => $user->id, 'status' => 2])->get()->count();
            $paided = Mission::where(['user_id' => $user->id, 'status' => 3])->get()->count();
        }else if($role->id >= 4){
            //return response()->json([],200);
            $all = Mission::whereHas('chauffeurs', function($query) use ($user){
                                return $query->where('users.id',$user->id);
                            })->get()->count();
            $load = Mission::whereHas('chauffeurs', function($query) use ($user){
                                return $query->where('users.id',$user->id);
                            })->where(['missions.status' => 1])->get()->count();
            $end = Mission::whereHas('chauffeurs', function($query) use ($user){
                                return $query->where('users.id',$user->id);
                            })->where(['missions.status' => 2])->get()->count();
            $paided = Mission::whereHas('chauffeurs', function($query) use ($user){
                                return $query->where('users.id',$user->id);
                            })->where(['missions.status' => 3])->get()->count();
        }

        return response()->json([
            'all' => $all,
            'load' => $load,
            'end' => $end,
            'paided' => $paided
        ], 200);
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
            'date_depart_pre' => 'required|after:tomorrow',
            'date_arriver_pre' => 'required|before_or_equal:date_depart_pre',
            'marchandise_id' => 'required',
            'destinataire_id' => 'required',
            'proposition_id' => 'required',
            'user_id' => 'required',
            'chauffeur_ids' => 'required',
            'vehicule_ids' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        $data = new Mission();
            $data->code = Mission::getCode();
            $data->code_livraison = Mission::getCodeL();
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
                Marchandise::find($data->marchandise_id)->update(['status' => 2]);

                $msgP = "Votre marchandise [" . $data->marchandise->libelle . "] est en cours de mission \n Date debut : ". date("Y M d ", strtotime($data->date_depart_pre))."\n Date fin : " . date("Y M d ", strtotime($data->date_arriver_pre));
                $phoneP = '+228'.$data->proprietaire->phone;

                $msgC = "Une mission de transport vous a été attributé [Livraison de " . $data->marchandise->libelle . "] \n Date debut : ". date("Y M d ", strtotime($data->date_depart_pre))."\n Date fin : " . date("Y M d ", strtotime($data->date_arriver_pre));
                $phoneC = '+228'.$data->chauffeurs[0]->phone;

                Mission::sendMessage($msgP,$phoneP);
                Mission::sendMessage($msgC,$phoneC);

            DB::commit();

            try{
                $user = $data->proprietaire->notify(new MissionNotification(new MissionResource($data)));
                $this->notification($user);
            }catch(Exception $e){}

        return response()->json(new MissionResource($data), 201);
    }

    public function notification($user)
    {
        $notifications = $user->unreadNotifications()->first();
        event(new NotificationEvent(['user_id' => $user->id, 'data' => $notifications]));
        return $notifications;
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

    public function upEnCours(Request $request, $id)
    {
        $data = Mission::find($id);
        $bordoreau_c = null;
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            if($request->bordoreau_c)
            {
                $bordoreau_c = File::write($request->bordoreau_c);
            }

            $data->update([
                'status' => 1,
                'bordoreau_c' => $bordoreau_c ? $bordoreau_c : null,
                'date_depart_eff' => date("Y-m-d H:i:s", strtotime(now())),
            ]);

            $msgD = "Mission de livraison \n[Livraison de " . $data->marchandise->libelle . "] \n Livraison prévu : " . date("Y M d ", strtotime($data->date_arriver_pre)). " \n Code : " . $data->code_livraison;
            $phoneD = '+228'.$data->destinataire->phone;

            Mission::sendMessage($msgD,$phoneD);

            return response()->json(new MissionResource($data), 200);
        }
    }

    public function upLivrer(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'code_livraison' => 'required',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);

        $data = Mission::find($id);
        $bordoreau_l = null;
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            if(isset($request->code_livraison) && $data->code_livraison != $request->code_livraison)
            {
                return response()->json(['error' => 'Code Incorrect'], 400);
            }

            if($request->bordoreau_l)
            {
                $bordoreau_l = File::write($request->bordoreau_l);
            }

            DB::beginTransaction();
                $data->update([
                    'status' => 2,
                    'bordoreau_l' => $bordoreau_l  ? $bordoreau_l : null,
                    'date_arriver_eff' => date("Y-m-d H:i:s", strtotime(now())),
                ]);

                foreach($data->vehicules as $vehicule){
                    $vehicule->update(['status' => 0]);
                }

                foreach($data->chauffeurs as $chauffeur){
                    $chauffeur->update(['status' => 0]);
                }

                Marchandise::find($data->marchandise_id)->update(['status' => 3]);

                $msg = "Votre marchandise [" . $data->marchandise->libelle . "] viens d'être livrée";
                $phone = '+228'.$data->proprietaire->phone;

                Mission::sendMessage($msg,$phone);

            DB::commit();
            return response()->json(new MissionResource($data), 200);
        }
    }

    public function upPayer(Request $request, $id)
    {
        $data = Mission::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {

        }
    }

    public function paiding(Request $request, $user_id, $mission_id){
        User::find($user_id)->update([
            'paiding' => 1
        ]);

        Mission::find($mission_id)->update([
            'paiding' => 1
        ]);

        return response()->json('OK', 200);
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
