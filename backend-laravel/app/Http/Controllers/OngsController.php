<?php

namespace App\Http\Controllers;

use App\Models\Ongs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OngsController extends Controller
{
    public function index()
    {
        $listOngs = Ongs::all();
        return response()->json($listOngs);
    }

    public function store(Request $request)
    {


        try{
            DB::beginTransaction();

            $id = strval(crc32(random_bytes(4)));

            Ongs::create([
                'id' => $id,
                'name' => $request->post('nome', ''),
                'email'=> $request->post('email', ''),
                'whatsapp' => $request->post('whatsapp', ''),
                'city' => $request->post('city', ''),
                'uf' => $request->post('uf', '')
            ]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'error' => $e ->getMessage()
            ], 400);
        }

        return response()->json(['id' => $id] , 200);
    }
}
