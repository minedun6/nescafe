<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\FicheTechnique;
use App\Models\Guideline;
use App\Models\NetworkType;
use App\Models\UserLogs;
use App\Services\Access\Facades\Access;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
class DocumentController extends Controller
{
    public function guidelineIndex()
    {
        return view('frontend.document.guidelines.list');
    }
	
    public function guidelineCreate()
    {
        return view('frontend.document.guidelines.add');
    }

    public function guidelineStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guideline' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $guide_line = new Guideline();
        $guide_line->nom = $request->name;
        $guide_line->cible = $request->weeks;
        if (Input::hasFile('guideline')) {
            $destinationPath = public_path('files/guidelines');
            $file_name = Input::file('guideline')->getClientOriginalName();
            $timestamp = \Carbon\Carbon::now()->timestamp;
            $fileName = $timestamp . $file_name;
            Input::file('guideline')->move($destinationPath, $fileName);
            $guide_line->path = 'files/guidelines/' . $fileName;

        }
        $guide_line->save();

        return redirect('/guideline/' . $guide_line->id);
    }

    public function guidelinePaginate(Request $request)
    {
        $generic_query = Guideline::where('nom', 'LIKE', "%" . $request->name . "%");
        if ($request->cible != '') {
            $generic_query = $generic_query->where('cible', '=', $request->cible);
        }
        $guide_lines_number = $generic_query->count();
        $guide_lines = $generic_query->paginate($request->length);
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $guide_lines_number,
            "recordsFiltered" => $guide_lines_number,
        ];
        $results["data"] = array();
        foreach ($guide_lines as $guide_line) {
            $logs_number = UserLogs::where('target', 'guideline')
                ->where('target_id', $guide_line->id)
                ->count();
            if (Access::hasRoles('Merch', 'Visiteur')) {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/guideline/" . $guide_line->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>';
            } else {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/guideline/edit/" . $guide_line->id) . '"><i
                                                        class="fa fa-edit"></i> Edit</a>' . '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/guideline/" . $guide_line->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>' . '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/guideline/delete/" . $guide_line->id) . '"><i
                                                        class="fa fa-trash"></i> Supprimer</a>';
            }
            $results["data"][] = array(
                $guide_line->created_at ? $guide_line->created_at->format('d/m/Y') : '',
                $guide_line->nom,
                $guide_line->cible,
                $logs_number,
                $actions
            );
        }

        return $results;
    }

    public function guidelineShow($id)
    {
        $guide_line = Guideline::find($id);
        if ($guide_line == null) {
            return redirect()->back();
        }

        $logs = UserLogs::where('target', 'guideline')
            ->where('target_id', $id)
            ->get();

        return view('frontend.document.guidelines.detail', array(
            'guide_line' => $guide_line,
            'logs' => $logs
        ));
    }

    public function guidelineEdit($id)
    {
        $guide_line = Guideline::find($id);
        return view('frontend.document.guidelines.edit', array(
            'guide_line' => $guide_line
        ));
    }

    public function guidelineUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'guideline' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $guide_line = Guideline::find($id);
        $guide_line->nom = $request->name;
        $guide_line->cible = $request->weeks;
        if (Input::hasFile('guideline')) {
            $destinationPath = public_path('files/guidelines');
            $file_name = Input::file('guideline')->getClientOriginalName();
            $timestamp = \Carbon\Carbon::now()->timestamp;
            $fileName = $timestamp . $file_name;
            Input::file('guideline')->move($destinationPath, $fileName);
            $guide_line->path = 'files/guidelines/' . $fileName;

        }
        $guide_line->save();
        $logs = UserLogs::where('target', 'guideline')
            ->where('target_id', $guide_line->id)
            ->get();
        foreach ($logs as $log) {
            $log->delete();
        }

        return redirect('/guideline/' . $guide_line->id);
    }

    public function guidelineDownload($id)
    {
        $guide_line = Guideline::find($id);
        if ($guide_line == null) {
            return redirect()->back();
        }
        $log = UserLogs::where('target', 'guideline')
            ->where('target_id', $guide_line->id)
            ->where('user_id', \Auth::user()->id)
            ->first();
        if ($log == null) {
            $new_log = new UserLogs();
            $new_log->user_id = \Auth::user()->id;
            $new_log->target = 'guideline';
            $new_log->target_id = $guide_line->id;
            $new_log->save();
        }

        $file = public_path($guide_line->path);
        return response()->download($file);
    }

    public function guidelineDelete($id)
    {
        $guide_line = Guideline::find($id);

        return view('frontend.document.guidelines.confirm-delete', array(
            'guide_line' => $guide_line
        ));
    }

    public function guidelineDestroy($id)
    {
        $guide_line = Guideline::find($id);
        $logs = UserLogs::where('target', 'guideline')
            ->where('target_id', $guide_line->id)
            ->get();
        foreach ($logs as $log) {
            $log->delete();
        }
        $guide_line->delete();

        return redirect('/guideline');
    }

    public function technicFileIndex()
    {

        $network_types = NetworkType::all();
        return view('frontend.document.technic.list', array(
            'network_types' => $network_types
        ));
    }

    public function technicFilePaginate(Request $request)
    {
        $generic_query = FicheTechnique::where('nom', 'LIKE', '%' . $request->name . '%')
            ->where('category', 'LIKE', '%' . $request->cat . '%')
            ->where('subcategory', 'LIKE', '%' . $request->scat . '%');
        if ($request->network != '')
            $generic_query = $generic_query->whereHas('network_type', function ($q) use ($request) {
                $q->where('code', '=', $request->network);
            });

        $files_number = $generic_query->count();
        $files = $generic_query->paginate($request->length);
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $files_number,
            "recordsFiltered" => $files_number,
        ];
        $results["data"] = array();
        foreach ($files as $file) {
            $logs_number = UserLogs::where('target', 'fiche')
                ->where('target_id', $file->id)
                ->count();
            if (Access::hasRoles('Merch', 'Visiteur')) {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/technic_file/" . $file->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>';
            } else {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/technic_file/edit/" . $file->id) . '"><i
                                                        class="fa fa-edit"></i> Edit</a>' . '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/technic_file/" . $file->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>' . '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/technic_file/delete/" . $file->id) . '"><i
                                                        class="fa fa-trash"></i> Supprimer</a>';
            }
            $results["data"][] = array(
                $file->created_at ? $file->created_at->format('d/m/Y') : '',
                $file->nom,
                $file->cible,
                $file->network_type_id ? $file->network_type->value : '',
                $file->category,
                $file->subcategory,
                $logs_number,
                $actions
            );
        }

        return $results;
    }

    public function technicFileCreate(Request $request)
    {
        $network_types = NetworkType::all();
        return view('frontend.document.technic.add', array(
            'network_types' => $network_types
        ));
    }

    public function technicFileStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fiche' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        DB::beginTransaction();
        $tech_file = new FicheTechnique();
        $tech_file->nom = $request->name;
        $tech_file->cible = $request->cible;
        $network = NetworkType::where('code', $request->network)->first();
        if ($network)
            $tech_file->network_type_id = $network->id;
        $tech_file->category = $request->cat;
        $tech_file->subcategory = $request->scat;

        if (Input::hasFile('fiche')) {
            $path = 'files/fiches/' . $network->code;
            $destinationPath = public_path($path);
            $file_name = Input::file('fiche')->getClientOriginalName();
            $timestamp = \Carbon\Carbon::now()->timestamp;
            $fileName = $timestamp . $file_name;
            Input::file('fiche')->move($destinationPath, $fileName);
            $tech_file->path = $path . '/' . $fileName;

        }
        $tech_file->save();
        DB::commit();
        return redirect('/technic_file/' . $tech_file->id);
    }

    public function technicFileShow($id)
    {
        $tech_file = FicheTechnique::find($id);
        if ($tech_file == null) {
            return redirect()->back();
        }
        $logs = UserLogs::where('target', 'fiche')
            ->where('target_id', $id)
            ->get();

        return view('frontend.document.technic.detail', array(
            'technic_file' => $tech_file,
            'logs' => $logs
        ));
    }

    public function technicFileEdit($id)
    {
        $file = FicheTechnique::find($id);
        $network_types = NetworkType::all();
        return view('frontend.document.technic.edit', array(
            'technic_file' => $file,
            'network_types' => $network_types
        ));
    }

    public function technicFileUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fiche' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $tech_file = FicheTechnique::find($id);
        $tech_file->nom = $request->name;
        $tech_file->cible = $request->cible;
        if (Input::hasFile('fiche')) {
            $destinationPath = public_path('files/fiches');
            $file_name = Input::file('fiche')->getClientOriginalName();
            $timestamp = \Carbon\Carbon::now()->timestamp;
            $fileName = $timestamp . $file_name;
            Input::file('fiche')->move($destinationPath, $fileName);
            $tech_file->path = 'files/fiches/' . $fileName;
        }
        $tech_file->save();
        $logs = UserLogs::where('target', 'fiche')
            ->where('target_id', $tech_file->id)
            ->get();
        foreach ($logs as $log) {
            $log->delete();
        }

        return redirect('/technic_file/' . $tech_file->id);
    }

    public function technicFileDownload($id)
    {
        $tech_file = FicheTechnique::find($id);
        if ($tech_file == null) {
            return redirect()->back();
        }
        $log = UserLogs::where('target', 'fiche')
            ->where('target_id', $tech_file->id)
            ->where('user_id', \Auth::user()->id)
            ->first();
        if ($log == null) {
            $new_log = new UserLogs();
            $new_log->user_id = \Auth::user()->id;
            $new_log->target = 'fiche';
            $new_log->target_id = $tech_file->id;
            $new_log->save();
        }

        $file = public_path($tech_file->path);
        return response()->download($file);
    }

    public function technicFileDelete($id)
    {
        $technic_file = FicheTechnique::find($id);

        return view('frontend.document.technic.confirm-delete', array(
            'technic_file' => $technic_file
        ));
    }

    public function technicFileDestroy($id)
    {
        $tech_file = FicheTechnique::find($id);
        $logs = UserLogs::where('target', 'fiche')
            ->where('target_id', $tech_file->id)
            ->get();
        foreach ($logs as $log) {
            $log->delete();
        }
        $tech_file->delete();

        return redirect('/technic_file');
    }
}
