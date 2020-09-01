<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShowResource;
use App\Link;
use App\User;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function chauffeurLibre()
    {
        $user = Auth::user();
        return UserShowResource::collection(User::where(['user_chauffeur_id' => $user->id, 'status' => 0])->get());
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
            'f_name' => 'required',
            'sexe' => 'required',
            'email' => 'required|email',
            'naissance' => 'required',
            'phone' => 'required',
            'ville' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|min:8',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        if($request->password != $request->c_password) return response()->json(['error' => 'Erreur de confirmation de mot de passe'], 400);
        if(User::where(['email' => $request->email])->first()) return response()->json(['error' => 'email exist'], 400);
        if(User::where(['username' => $request->username])->first()) return response()->json(['error' => 'username exist'], 400);
        $data = new User();
            $data->code = User::getCode();
            $data->name = $request->name;
            $data->f_name = $request->f_name;
            $data->sexe = $request->sexe;
            $data->email = $request->email;
            $data->naissance = $request->naissance;
            $data->phone = $request->phone;
            $data->ville_id = $request->ville;
            $data->username = $request->username;
            $data->password = md5($request->password);
            $data->is_actived = 0;

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

        return response()->json(new UserResource($data), 201);
    }

    public function sendMail($data, $link)
    {
        try{
            $to_name = $data->name .' '. $data->f_name;
            $to_email = $data->email;
            $sender = 'offridamjc@gmail.com';
            $sender_name = 'FreatLoad';
            $data = ['user'=> $data, "link" => $link];
            Mail::send('emails/mail_active', $data,
            function($message) use ($to_name, $to_email, $sender, $sender_name) {
                $message->to($to_email, $to_name)
                ->subject('Activer votre compte FretLoad');
                $message->from($sender,$sender_name);
            });
        }catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'f_name' => 'required',
            'sexe' => 'required',
            'email' => 'required|email',
            'naissance' => 'required',
            'phone' => 'required',
            'ville' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|min:8',
        ]);

        if($v->fails()) return response()->json($v->errors(), 400);
        if($request->password != $request->c_password) return response()->json(['error' => 'Erreur de confirmation de mot de passe'], 400);
        if(User::where(['email' => $request->email])->first()) return response()->json(['error' => 'email exist'], 400);
        if(User::where(['username' => $request->username])->first()) return response()->json(['error' => 'username exist'], 400);
        $data = new User();
            $data->code = User::getCode();
            $data->name = $request->name;
            $data->f_name = $request->f_name;
            $data->sexe = $request->sexe;
            $data->email = $request->email;
            $data->naissance = $request->naissance;
            $data->phone = $request->phone;
            $data->ville_id = $request->ville;
            $data->username = $request->username;
            $data->password = md5($request->password);
            $data->is_actived = 0;

            if($request->adresse) $data->adresse = $request->adresse;
            if($request->photo)
            {
                $name = File::write($request->photo);
                if($name)
                {
                    $data->photo = $name;
                }
            }

            DB::beginTransaction();
                $data->save();
                $l = Link::create([
                    'code' => Link::getCode(),
                    'user_id' => $data->id
                ]);
            DB::commit();
        $link = $request->url."#/active/".$l->code.'/users';
        if($this->sendMail($data, $link))
        {
            return response()->json(new UserResource($data), 201);
        }
        else
        {
            return response()->json(["Error" => "Envoie de mail échoué"], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        return response()->json(new UserResource($data), 200);
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
        $data = User::find($id);
        $all = $request->all();
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else{

            /*$request->name ? $data->name = $request->name : null;
            $request->f_name ? $data->f_name = $request->f_name : null;
            $request->sexe ? $data->sexe = $request->sexe : null;
            $request->email ? $data->email = $request->email : null;
            $request->naissance ? $data->naissance = $request->naissance : null;
            $request->adresse ? $data->adresse = $request->adresse : null;
            $request->phone ? $data->phone = $request->phone : null;
            $request->ville ? $data->ville_id = $request->ville : null;
            $request->username ? $data->username = $request->username : null;*/

            if($all->password != null && $all->o_password != null && $all->c_password != null)
            {
                if($data->password == md5($all->o_password ))
                {
                    if($all->password != $all->password_conf) return response()->json(['error' => 'Erreur de confirmation de mot de passe'], 400);
                        $data->password = $all->password;
                }else return response()->json(['error' => 'Ancien mot de passe inccorect'], 404);
            }

            if($all['photo'])
            {
                $name = File::write($all['photo']);
                if($name)
                {
                    $all['photo'] = $name;
                }else $all['photo'] = $data->photo;
            }

            $data->update($all);

            return response()->json(new UserResource($data), 200);
        }
    }

    public function active($id, $state)
    {
        if($state >= 0 && $state <=1)
        {
            User::where(['id' => $id])->update(['is_active' => $state]);
            return response()->json(true, 200);
        }
        return response()->json(false, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if(is_null($data))
            return response()->json(['error' => 'Resource introuvable'], 404);
        else
        {
            $data->destroy();
            return response()->json(true, 200);
        }
    }
}
