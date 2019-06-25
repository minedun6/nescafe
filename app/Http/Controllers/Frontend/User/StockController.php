<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Approvisionnement;
use App\Models\ILV;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function paginate(Request $request, $id)
    {
        $stocks = Approvisionnement::where('ilv_id', $id)
            ->paginate($request->length);
        $stock_counts = $stocks->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $stock_counts,
            "recordsFiltered" => $stock_counts,
        ];

        $results["data"] = array();
        foreach ($stocks as $stock) {
            $results["data"][] = array(
                $stock->created_at ? $stock->created_at->format('d/m/Y') : '',
                $stock->quantity,
                '<a class="edit-button btn dark" data-id="' . $stock->id . '" data-target="#pop_up_edit_0"
                 data-toggle="modal">Editer</a>
                 <a href="' . url('/appro/delete/' . $stock->id) . '" class="btn dark">Supprimer</a>'
            );
        }

        return $results;
    }

    public function add(Request $request, $id)
    {
        if ($request->quantity == null) {
            return redirect()->back();
        }
        DB::beginTransaction();
        $appro = new Approvisionnement();
        $appro->quantity = $request->quantity;
        $appro->ilv_id = $id;
        $appro->save();
        DB::commit();

        return redirect('/ilv/detail/' . $id);
    }

    public function edit(Request $request)
    {
        if ($request->quantity == null || $request->appro_id == null) {
            return redirect()->back();
        }
        DB::beginTransaction();
        $appro = Approvisionnement::find($request->appro_id);
        $ilv_id = $appro->ilv_id;
        $appro->quantity = $request->quantity;
        $appro->save();
        DB::commit();

        return redirect('/ilv/detail/' . $ilv_id);
    }

    public function destroy($id)
    {
        $appro = Approvisionnement::find($id);
        $ilv = $appro->ilv;
        $appro->delete();


        return redirect('/ilv/detail/' . $ilv->id);
    }
}
