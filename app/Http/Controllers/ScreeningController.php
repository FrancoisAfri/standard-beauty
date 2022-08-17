<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyIdentity;
use App\HRPerson;
use App\ScreeningSetup;
use App\EmployeeScreening;
use App\VisitorsScreening;
use App\DivisionLevelFive;
use App\DivisionLevelFour;
use App\DivisionLevelOne;
use App\DivisionLevelThree;
use App\DivisionLevelTwo;
use App\DivisionLevel;
use App\User;
use App\Http\Controllers\AuditReportsController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ScreeningController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Auth::user()->load('person');
		$levelsFive = DivisionLevel::where('active', 1)->where('level', 5)->first();
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		if ($user->person->id === 1)
		{
			$companyFive = DivisionLevelFive::where('active', 1)->orderBy('name', 'asc')->get();
			$companyFour = DivisionLevelFour::where('active', 1)->orderBy('name', 'asc')->get();
			$users = DB::table('hr_people')->where('status', 1)->orderBy('first_name', 'asc')->get();
		}
		else
		{
			$users = DB::table('hr_people')->where('status', 1)->where('division_level_5', $user->person->division_level_5)->orderBy('first_name', 'asc')->get();
			$companyFive = DivisionLevelFive::where('active', 1)->where('id', $user->person->division_level_5)->orderBy('name', 'asc')->get();
			$companyFour = DivisionLevelFour::where('active', 1)->where('parent_id', $user->person->division_level_5)->orderBy('name', 'asc')->get();
		}
		$data['levelsFive'] = $levelsFive;
        $data['levelsFour'] = $levelsFour;
        $data['companyFive'] = $companyFive;
        $data['companyFour'] = $companyFour;
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Visitors Screening";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/register-new-user', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Visitors Screening', 'active' => 1, 'is_module' => 0]
        ];
		$data['active_mod'] = 'Screening';
        $data['active_rib'] = 'Visitors Screening';
		AuditReportsController::store('Screening', 'Screening Page Accessed', "Accessed By User", 0);
        return view('screening.visitors_screening')->with($data);
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
        //Validation
        $validator = Validator::make($request->all(), [
			'question_1' => 'required',
			'question_2' => 'required',
			'question_3' => 'required',
			'question_4' => 'required',
			'question_5' => 'required',
			'question_6' => 'required',
			'question_7' => 'required',
			'question_8' => 'required',
			'employee_number' => 'required',
        ]);
        $validator->after(function ($validator) use($request) {
            $employeeNumber = $request->input('employee_number');
            $today = strtotime(date('Y-m-d'));
			if (!empty($employeeNumber))
			{
				$screening = EmployeeScreening::where('employee_number', $employeeNumber)->where('date_captured','=' ,$today)->first();
				if (!empty($screening))
					$validator->errors()->add('screening_done', "This form have already been completed for today.");
			}
			else
				$validator->errors()->add('screening_done', "You do not have employee number assign. Please update your profile first");
        });
        if ($validator->fails()) {
            return redirect("/")
                ->withErrors($validator)
                ->withInput();
        }
		$user = Auth::user()->load('person');
		$today = strtotime(date('Y-m-d'));
		$EmployeeScreening = new EmployeeScreening;
        $EmployeeScreening->question_1 = $request->question_1;
        $EmployeeScreening->question_2 = $request->question_2;
        $EmployeeScreening->question_3 = $request->question_3;
        $EmployeeScreening->question_4 = $request->question_4;
        $EmployeeScreening->question_5 = $request->question_5;
        $EmployeeScreening->question_6 = $request->question_6;
        $EmployeeScreening->question_7 = $request->question_7;
        $EmployeeScreening->question_8 = $request->question_8;
        $EmployeeScreening->employee_number = $request->employee_number;
        $EmployeeScreening->employee_id = $user->person->id;
        $EmployeeScreening->company_id = $user->person->division_level_5;
        $EmployeeScreening->site_id = $user->person->division_level_4;
        $EmployeeScreening->date_captured = $today;
        $EmployeeScreening->save();

		AuditReportsController::store('Screening', 'Completed Screening', "Performed BY User", 0);
		//Redirect to all usr view
		return back()->with('success_add', "Record has been successfully saved");
    }
	
	public function visitorsScreening(Request $request)
    {
		//Validation
        $validator = Validator::make($request->all(), [
			'question_1' => 'required',
			'question_2' => 'required',
			'question_3' => 'required',
			'question_4' => 'required',
			'question_5' => 'required',
			'question_6' => 'required',
			'question_7' => 'required',
			'question_8' => 'required',
			'temperature' => 'required',
			'new_id_number' => 'required',
			'client_name' => 'required',
			'cell_number' => 'required',
			'division_level_5' => 'required',
			'division_level_4' => 'required',
        ]);
        $validator->after(function ($validator) use($request) {
            $idNumber = $request->input('new_id_number');
            $today = strtotime(date('Y-m-d'));
			if (!empty($idNumber))
			{
				if(is_numeric($idNumber) && strlen($idNumber) == 13)
				{
					$screening = VisitorsScreening::where('new_id_number', $idNumber)->where('date_captured','=' ,$today)->first();
					if (!empty($screening))
						$validator->errors()->add('screening_done', "A visitor with this ID Number have already been screened today.");
				}
				else
					$validator->errors()->add('new_id_number', "The ID Number Must have thirteen digits.");
			}
        });
        if ($validator->fails()) {
            return redirect("/screening/visitors_screening")
                ->withErrors($validator)
                ->withInput();
        }
		$user = Auth::user()->load('person');
		$today = strtotime(date('Y-m-d'));
		$temp = str_replace(",",".",$request->input('temperature'));
		$VisitorsScreening = new VisitorsScreening;
        $VisitorsScreening->question_1 = $request->question_1;
        $VisitorsScreening->question_2 = $request->question_2;
        $VisitorsScreening->question_3 = $request->question_3;
        $VisitorsScreening->question_4 = $request->question_4;
        $VisitorsScreening->question_5 = $request->question_5;
        $VisitorsScreening->question_6 = $request->question_6;
        $VisitorsScreening->question_7 = $request->question_7;
        $VisitorsScreening->question_8 = $request->question_8;
        $VisitorsScreening->temperature = $temp;
        $VisitorsScreening->new_id_number = $request->new_id_number;
        $VisitorsScreening->client_name = $request->client_name;
        $VisitorsScreening->cell_number = $request->cell_number;
        $VisitorsScreening->comment = !empty($request->comment) ? $request->comment : '';
        $VisitorsScreening->captured_id = $user->person->id;
        $VisitorsScreening->company_id = $request->division_level_5;
        $VisitorsScreening->site_id = $request->division_level_4;
        $VisitorsScreening->date_captured = $today;
        $VisitorsScreening->covid_admin = $user->person->id;
        $VisitorsScreening->save();
		
		AuditReportsController::store('Screening', 'Visitor Screening', "Performed BY User", 0);
		// check if temperature is over setup
		$setup = ScreeningSetup::first();
		$maxTemp = $setup->max_temperature;
		if ($VisitorsScreening->temperature > $maxTemp)
			return back()->with('success_add', "Visitor temperature is too high. He/She must go to a doctor.");
		//Redirect to all usr view
        return back()->with('success_add', "Visitor Screening Have Been Successfull");
    }
	// temp save
	public function tempSave(Request $request)
    {
		//Validation
       $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'temperature' => 'required',
        ]);
        $validator->after(function ($validator) use($request) {
            $userID = $request->input('user_id');
            $today = strtotime(date('Y-m-d'));
			if (!empty($userID))
			{
				$screening = EmployeeScreening::where('employee_id', $userID)->where('date_captured','=' ,$today)->first();
				if (empty($screening))
					$validator->errors()->add('screening_done', "Sorry this action can not proceed!!! This employee have not completed screening form for today.");
				if (!empty($screening->temperature))
					$validator->errors()->add('screening_done', "Sorry this action can not proceed!!! Temperature have already been saved for this employee.");
			}
        });
        if ($validator->fails()) {
            return redirect("/screening/temp/record")
                ->withErrors($validator)
                ->withInput();
        }
		$user = Auth::user()->load('person');
		$userID = $request->input('user_id');
		$today = strtotime(date('Y-m-d'));
		$setup = ScreeningSetup::first();
		$screening = EmployeeScreening::where('employee_id', $userID)->where('date_captured','=' ,$today)->first();

		if (!empty($screening))
		{
			$temp = str_replace(",",".",$request->input('temperature'));
            $screening->clockin_time = date('H:i:s');
            $screening->temperature = $temp;
            $screening->covid_admin = $user->person->id;
            $screening->update();
		}
		AuditReportsController::store('Screening', 'Temperature Saved', "Performed BY User", 0);
		// check if temperature is over setup
		$maxTemp = $setup->max_temperature;
		if ($request->input('temperature') > $maxTemp)
			return back()->with('success_add', "Temperature is too high. He/She must go to a doctor.");
		//Redirect to all usr view
        return back()->with('success_add', "Temperature Been Successfully Saved");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
		$user = Auth::user()->load('person');
		if ($user->person->id === 1)
			$users = DB::table('hr_people')->where('status', 1)->orderBy('first_name', 'asc')->get();
		else
			$users = DB::table('hr_people')->where('status', 1)->where('division_level_5', $user->person->division_level_5)->orderBy('first_name', 'asc')->get();

        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Temperature Recording";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/register-new-user', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Temperature', 'active' => 1, 'is_module' => 0]
        ];
		$data['active_mod'] = 'Screening';
        $data['active_rib'] = 'Temperature';
        $data['users'] = $users;
		AuditReportsController::store('Screening', 'Screening Page Accessed', "Accessed By User", 0);
        return view('screening.capture_temp')->with($data);
    } 
	
	public function viewQuestions(EmployeeScreening $viewID)
    {
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Employees Screening Answers";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Answers', 'active' => 1, 'is_module' => 0]
        ];
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		$viewID = $viewID->load('employee','administrtor','site');
        $data['answer'] = $viewID;
		$data['levelsFour'] = $levelsFour;
		AuditReportsController::store('Screening', 'Employee Screening Answers Accessed', "Accessed By User", 0);
        return view('screening.view_employees_answers')->with($data);
    }	
	
	public function viewClientQuestions(VisitorsScreening $viewID)
    {
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Visitors Screening Answers";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Answers', 'active' => 1, 'is_module' => 0]
        ];
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		$viewID = $viewID->load('administrtor','site');
        $data['answer'] = $viewID;
		$data['levelsFour'] = $levelsFour;
		AuditReportsController::store('Screening', 'Visitors Screening Answers Page Accessed', "Accessed By User", 0);
        return view('screening.view_visitors_answers')->with($data);
    }
// 
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
	public function reports()
    {
		$user = Auth::user()->load('person');
		
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Screening Reports";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 1],
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 0],
            ['title' => 'Screening Reports', 'active' => 1, 'is_module' => 0]
        ];
		
        $data['active_mod'] = 'Screening';
        $data['active_rib'] = 'Reports';
		$levelsFive = DivisionLevel::where('active', 1)->where('level', 5)->first();
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();

		if ($user->person->id === 1)
		{
			$companyFive = DivisionLevelFive::where('active', 1)->orderBy('name', 'asc')->get();
			$companyFour = DivisionLevelFour::where('active', 1)->orderBy('name', 'asc')->get();
			$users = DB::table('hr_people')->where('status', 1)->orderBy('first_name', 'asc')->get();
		}
		else
		{
			$users = DB::table('hr_people')->where('status', 1)->where('division_level_5', $user->person->division_level_5)->orderBy('first_name', 'asc')->get();
			$companyFive = DivisionLevelFive::where('active', 1)->where('id', $user->person->division_level_5)->orderBy('name', 'asc')->get();
			$companyFour = DivisionLevelFour::where('active', 1)->where('parent_id', $user->person->division_level_5)->orderBy('name', 'asc')->get();
		}
		$data['users'] = $users;
		$data['levelsFive'] = $levelsFive;
		$data['levelsFour'] = $levelsFour;
		$data['companyFive'] = $companyFive;
		$data['companyFour'] = $companyFour;
		AuditReportsController::store('Screening', 'View Screening Search', "view Screening", 0);
        return view('screening.reports.report_search')->with($data);
    }
	// draw audit report acccording to search criteria
	public function getReport(Request $request)
    {
		$dateFrom = $dateTo = 0;
		$actionDate = $request->date_captured;
		$comID = $request->division_level_5;
		$siteID = $request->division_level_4;
		$userID = $request->user_id;
		$setup = ScreeningSetup::first();
		$maxTemp = $setup->max_temperature;
		if (!empty($actionDate))
		{
			$startExplode = explode('-', $actionDate);
			$dateFrom = strtotime($startExplode[0]);
			$dateTo = strtotime($startExplode[1]);
		}
		$screenings = EmployeeScreening::
		where(function ($query) use ($dateFrom, $dateTo) {
		if ($dateFrom > 0 && $dateTo  > 0) {
			$query->whereBetween('employee_screenings.date_captured', [$dateFrom, $dateTo]);
		}
		})
		->where(function ($query) use ($userID) {
		if (!empty($userID)) {
			$query->where('employee_screenings.employee_id', $userID);
		}
		})
		->where(function ($query) use ($siteID) {
		if (!empty($siteID)) {
			$query->where('employee_screenings.site_id', $siteID);
		}
		})
		->where(function ($query) use ($comID) {
		if (!empty($comID)) {
			$query->where('employee_screenings.company_id', $comID);
		}
		})
		->orderBy('employee_screenings.date_captured')
		->get();
		// check if all questions have been completed
		if (!empty($screenings))
		{		
			foreach ($screenings as $c) {
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
		if (!empty($screenings)) 
			$screenings = $screenings->load('employee','administrtor','site');

		$levelsFive = DivisionLevel::where('active', 1)->where('level', 5)->first();
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		$companyFive = DivisionLevelFive::where('active', 1)->where('id', $comID)->first();
		
		$data['companyFive'] = $companyFive;
		$data['levelsFive'] = $levelsFive;
		$data['levelsFour'] = $levelsFour;
        $data['date_captured'] = $request->date_captured;
        $data['division_level_5'] = $request->division_level_5;
        $data['division_level_4'] = $request->division_level_4;
        $data['user_id'] = $request->user_id;
        $data['screenings'] = $screenings;
		$data['active_mod'] = 'Screening';
        $data['active_rib'] = 'Reports';
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Employees Reports";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 1],
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 0],
            ['title' => 'Screening Reports', 'active' => 1, 'is_module' => 0]
        ];
	
		AuditReportsController::store('Screening', 'View Employee Screening Search Results', "Employee Screening Results", 0);
        return view('screening.reports.report_emp_results')->with($data);
    }
	// draw audit report acccording to search criteria
	public function getReportvis(Request $request)
    {
		$dateFrom = $dateTo = 0;
		$actionDate = $request->date_captured;
		$comID = $request->division_level_5;
		$siteID = $request->division_level_4;
		$setup = ScreeningSetup::first();
		$maxTemp = $setup->max_temperature;
		if (!empty($actionDate))
		{
			$startExplode = explode('-', $actionDate);
			$dateFrom = strtotime($startExplode[0]);
			$dateTo = strtotime($startExplode[1]);
		}
		$screenings = VisitorsScreening::
		where(function ($query) use ($dateFrom, $dateTo) {
		if ($dateFrom > 0 && $dateTo  > 0) {
			$query->whereBetween('visitors_screenings.date_captured', [$dateFrom, $dateTo]);
		}
		})
		->where(function ($query) use ($siteID) {
		if (!empty($siteID)) {
			$query->where('visitors_screenings.site_id', $siteID);
		}
		})
		->where(function ($query) use ($comID) {
		if (!empty($comID)) {
			$query->where('visitors_screenings.company_id', $comID);
		}
		})
		->orderBy('visitors_screenings.date_captured')
		->get();
		// check if all questions have been completed
		if (!empty($screenings))
		{		
			foreach ($screenings as $c) {
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
		if (!empty($screenings)) 
			$screenings = $screenings->load('administrtor','site');
		
		//return $screenings;
		$levelsFive = DivisionLevel::where('active', 1)->where('level', 5)->first();
		$levelsFour = DivisionLevel::where('active', 1)->where('level', 4)->first();
		$companyFive = DivisionLevelFive::where('active', 1)->where('id', $comID)->first();
		
		$data['companyFive'] = $companyFive;
		$data['levelsFive'] = $levelsFive;
		$data['levelsFour'] = $levelsFour;
        $data['date_captured'] = $request->date_captured;
        $data['division_level_5'] = $request->division_level_5;
        $data['division_level_4'] = $request->division_level_4;
        $data['screenings'] = $screenings;

        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Screening Reports";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 1],
            ['title' => 'Screening', 'path' => '/screening/report', 'icon' => 'fa fa-eye', 'active' => 0, 'is_module' => 0],
            ['title' => 'Screening Reports', 'active' => 1, 'is_module' => 0]
        ];
	
		AuditReportsController::store('Screening', 'View Screening Search Results', "view Screening Results", 0);
        return view('screening.reports.report_vis_results')->with($data);
    }
	public function setup()
    {
		$setup = ScreeningSetup::first();
        $data['page_title'] = "Online Screening";
        $data['page_description'] = "Setup";
        $data['breadcrumb'] = [
            ['title' => 'Screening', 'path' => '/screening/setup', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Setup', 'active' => 1, 'is_module' => 0]
        ];
		
        $data['active_mod'] = 'Screening';
        $data['active_rib'] = 'Setup';
        $data['setup'] = $setup;
        AuditReportsController::store('Screening', 'Setup Page Accessed', "Accessed By User", 0);
        return view('screening.setup')->with($data);
    }
	public function saveSetup(Request $request)
    {
        $this->validate($request, [
            'max_temperature' => 'required',
        ]);
			
        $setup = ScreeningSetup::first();
		
        if ($setup) { //update
            $setup->update($request->all());
        } else { //insert
            $setup = new ScreeningSetup($request->all());
            $setup->save();
        }
		AuditReportsController::store('Screening', "Setup Saved", "Saved by User", 0);
        return back()->with('changes_saved', 'Your changes have been saved successfully.');
    }
	public function addComment(Request $request, EmployeeScreening $comment) 
	{
		$this->validate($request, [
            'comment' => 'required',
        ]);
		$user = Auth::user();
		$commentData = $request->all();

        //Exclude empty fields from query
        foreach ($commentData as $key => $value)
        {
            if (empty($commentData[$key])) {
                unset($commentData[$key]);
            }
        }
        
		# update comment
		$comment->comment = !empty($commentData['comment']) ? $commentData['comment'] : '';
		$comment->update();
		
		AuditReportsController::store('Screening', "Comment Added", "Added by User", 0);
		return response()->json(['comment' => $commentData['comment']], 200);
    }
}