<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PartnerProjectController extends Controller
{
    use ApiResponseTrait;
    public function showPartners(Request $request)
    {
        $partners=[];
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id'
        ]);

        $availablePartners=Partner::whereNotExists(function($query) use ($request){
            $query->select(DB::raw(1))->from('project_partner')
            ->where('project_id','=',$request->project_id)
            ->whereColumn('partner_id','partners.id');
        })->get();

        // $project=Project::find($request->project_id);
        // $partnersForProject = $project->partners;
        // $partners=Partner::all();
        // $availablePartners = $partners->diff($partnersForProject);
        return $availablePartners;
    }

    public function store(Request $request)
    {
        //Validate request
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'partner_id' => 'required|integer|exists:partners,id',
        ]);

        $projectPartner=ProjectPartner::firstOrCreate([
            'project_id' => $request->input('project_id'),
            'partner_id' => $request->input('partner_id'),
        ]);

        return $this->apiResponse($projectPartner,'Partner added Successfully to the Project',Response::HTTP_CREATED);
    }
}