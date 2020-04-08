<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        /*if(!$request->hasHeader('authorization') || is_null(Session('ong')) || $request->header('authorization') != Session('ong')['id']){
            return response()->json([
                'error' => 'Operation not permitted.'
            ], 400);
        }*/

        $listIncidents = Incidents::with('Ongs')->where('ong_id', $request->header('authorization'))->get();

        return response()->json($listIncidents, 200);
    }
}
