<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mission;
use App\Payement;
use App\User;
use Illuminate\Http\Request;

class PayementConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mission = Mission::where(['paiding' => 1])->first();
        $user = User::where(['paiding' => 1])->first();
        if($mission && $user)
        {
            $mission->update([
                'status' => 3,
                'paiding' => 0
            ]);

            $user->update([
                'paiding' => 0
            ]);

            Payement::create([
                'montant' => $mission->montant,
                'mode_payement_id' => 1,
                'mission_id' => $mission->id,
                'user_id' => $user->id
            ]);

            $msg = "La livraison de [ " . $mission->marchandise->libelle . " ]  a ete payer ";
            $phone = '+228'.$mission->transpoteur->phone;

            Mission::sendMessage($msg,$phone);
        }

        return redirect('https://fretload.herokuapp.com/#/app/missions/paided');
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
