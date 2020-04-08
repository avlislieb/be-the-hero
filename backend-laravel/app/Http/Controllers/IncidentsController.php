<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use App\Models\Ongs;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidentsController extends Controller
{

    public function index(Request $request)
    {
        $page = (int) $request->get('page', 1);

        $listIncidents = Incidents::with('Ongs')->skip((($page - 1) * 5))->take(5)->get();

        return response()->json($listIncidents, 200);
    }

    public function store(Request $request)
    {

        try{
            DB::beginTransaction();

            ['title' => $title, 'description' => $description, 'value' => $value] = $request->all();

            $ong = Ongs::findOrFail($request->header('authorization'));

            ['id' => $id] = $ong->Incidents()->create([
                'title' => $title,
                'description' => $description,
                'value' => $value
            ]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([ 'id' => $id ], 200);
    }

    public function delete(Request $request, $id)
    {

        try{
            DB::beginTransaction();

                $incident = Incidents::select(['ong_id', 'id'])->findOrFail($id);

                if($incident->ong_id != $request->header('authorization'))
                    abort(400);

                $incident->delete();

            DB::commit();
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Operation not permitted.'
            ], 400);
        }

        return Response::make('', 204);
    }
}
