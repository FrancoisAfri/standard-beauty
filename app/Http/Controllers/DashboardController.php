<?php

namespace App\Http\Controllers;

use App\DivisionLevel;
use App\DivisionLevelFive;
use App\DivisionLevelFour;
use App\DivisionLevelOne;
use App\ScreeningSetup;
use App\DivisionLevelThree;
use App\DivisionLevelTwo;
use App\EmployeeScreening;
use App\VisitorsScreening;
use App\CompanyIdentity;
use App\Cmsnews;
use App\HRPerson;
use App\module_access;
use App\Http\Requests;
use App\modules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

		$user = Auth::user()->load('person');

		if ($user->person->id === 1) 
		{
			$companyID = 0;
			$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		}
		else
		{
			$companyID = $user->person->division_level_5;
			$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		}
		//check if user can view the (must be admin)
		$objscreeningModAccess = module_access::where('module_id', 4)->where('user_id', $user->id)->get();
		if ($objscreeningModAccess && count($objscreeningModAccess) > 0)
			$access = $objscreeningModAccess->first()->access_level;
		else
			$access = 0;
		
		$adminAccess = ($access >= 4) ? true : false;
        
        $data['active_mod'] = 'dashboard';
		$labelColors = ['' => 'danger', 5 => 'warning', 6 => 'primary', 7 => 'primary', 8 => 'success'];
        $activeModules = modules::where('active', 1)->get();
        if ($user->type === 1 || $user->type === 3) {
            
            $statusLabels = [10 => "label-danger", 50 => "label-warning", 80 => 'label-success', 100 => 'label-info'];
			$setup = ScreeningSetup::first();
			$maxTemp = !empty($setup->max_temperature) ? $setup->max_temperature: 0 ;
			// Get screening for logged user
            $today = strtotime(date('Y-m-d'));
            $screenings = EmployeeScreening::
				where('date_captured', '=', $today)
                ->where(function ($query) use ($companyID) {
					if (!empty($companyID)) {
						$query->where('company_id', $companyID);
					}
				})
                ->orderBy('date_captured')
                ->get();
			// check if all questions have been completed
			if (!empty($screenings))
			{		
				foreach ($screenings as $q) {
					if ($q->question_1 == 2 && $q->question_2 == 2 && $q->question_3 == 2 && $q->question_4 == 2
						&& $q->question_5 == 2 && $q->question_6 == 2 && $q->question_7 == 2 && $q->question_8 == 2)
						$q->background = '';
					else $q->background = 'orange';
					// check if temperature is over setup
					if ($q->temperature > $maxTemp)
						$q->background_temp = 'red';
					else $q->background_temp = '';
				}
			}
			
			// load relationshi
			if (!empty($screenings))
			$screenings = $screenings->load('employee','administrtor','site');
			
			// get clients screening details
			$today = strtotime(date('Y-m-d'));
            $clientScreenings = VisitorsScreening::
				where('date_captured', '=', $today)
                ->where(function ($query) use ($companyID) {
					if (!empty($companyID)) {
						$query->where('company_id', $companyID);
					}
				})
                ->orderBy('client_name')
                ->get();
			// check if all questions have been completed
			if (!empty($clientScreenings))
			{		
				foreach ($clientScreenings as $c) {
					if ($c->question_1 == 2 && $c->question_2 == 2 && $c->question_3 == 2 && $c->question_4 == 2
						&& $c->question_5 == 2 && $c->question_6 == 2 && $c->question_7 == 2 && $c->question_8 == 2)
						$c->background = '';
					else 
						$c->background = 'orange';
					
					// check if temperature is over setup
					if ($c->temperature > $maxTemp)
						$c->background_temp = 'red';
					else $c->background_temp = '';
				}
			}
			// load relationships
			if (!empty($clientScreenings))
			$clientScreenings = $clientScreenings->load('administrtor','site');
			$companyDetails = CompanyIdentity::systemSettings();
			$broughtToText = $companyDetails['brought_to_text'];
			$isDemo = !empty($companyDetails['is_demo']) ? $companyDetails['is_demo'] : 3 ;
			$data['breadcrumb'] = [
				['title' => 'Dashboard', 'path' => '/', 'icon' => 'fa fa-dashboard', 'active' => 1, 'is_module' => 1]
			];
            $data['activeModules'] = $activeModules;
            $data['user'] = $user;
            $data['adminAccess'] = $adminAccess;
            $data['levelsFour'] = $levelsFour;
            $data['screenings'] = $screenings;
            $data['clientScreenings'] = $clientScreenings;

            $data['page_title'] = $broughtToText;
            $data['isDemo'] = $isDemo;
            //$data['page_description'] = "Dashboard.";

            return view('dashboard.admin_dashboard')->with($data); //Admin Dashboard
        }
    }
}