<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmRegistration;
use App\CompanyIdentity;
use App\HRPerson;
use App\DivisionLevelFive;
use App\DivisionLevelFour;
use App\DivisionLevelOne;
use App\DivisionLevelThree;
use App\DivisionLevelTwo;
use App\DivisionLevel;
use App\module_access;
use App\User;
use App\Cmsnews;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\AuditReportsController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class NewUsersRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
        $this->middleware('guest');
    }
	
    public function index()
    {
        $companyDetails = CompanyIdentity::systemSettings();
		$divisionLevels = DivisionLevel::where('active', 1)->orderBy('id', 'desc')->get();
		$today = time();
        $news = Cmsnews::where('status', 1)
			->where('expirydate', '>=', $today)
			->where('adv_number',1)
			->first();
		$secondNews = Cmsnews::where('status', 1)
			->where('expirydate', '>=', $today)
			->where('adv_number',2)
			->first();
			
		$data['page_title'] = "New Account";
        $data['page_description'] = "Create a New Account";
        $data['breadcrumb'] = [
            ['title' => 'Security', 'path' => '/register-new-user', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Create user', 'active' => 1, 'is_module' => 0]
        ];
		
		$data['news'] = $news;
        $data['secondNews'] = $secondNews;
		$data['division_levels'] = $divisionLevels;
		$data['skinColor'] = $companyDetails['sys_theme_color'];
        $data['headerAcronymBold'] = $companyDetails['header_acronym_bold'];
        $data['headerAcronymRegular'] = $companyDetails['header_acronym_regular'];
        $data['headerNameBold'] = $companyDetails['header_name_bold'];
        $data['headerNameRegular'] = $companyDetails['header_name_regular'];
        $data['company_logo'] = $companyDetails['company_logo_url'];
		AuditReportsController::store('Security', 'New User Registration Page Accessed', "Accessed By Guest", 0);
        return view('security.guests.new-user-registration')->with($data);
    }
	
	public function demo()
    {
        $companyDetails = CompanyIdentity::systemSettings();
		
		$data['page_title'] = "Demo Account";
        $data['page_description'] = "Create Demo Account";
        $data['breadcrumb'] = [
            ['title' => 'Security', 'path' => '/demo-user', 'icon' => 'fa fa-lock', 'active' => 0, 'is_module' => 1],
            ['title' => 'Create user', 'active' => 1, 'is_module' => 0]
        ];
		
		$data['skinColor'] = $companyDetails['sys_theme_color'];
        $data['headerAcronymBold'] = $companyDetails['header_acronym_bold'];
        $data['headerAcronymRegular'] = $companyDetails['header_acronym_regular'];
        $data['headerNameBold'] = $companyDetails['header_name_bold'];
        $data['headerNameRegular'] = $companyDetails['header_name_regular'];
        $data['company_logo'] = $companyDetails['company_logo_url'];
		AuditReportsController::store('Security', 'New User Registration Page Accessed', "Accessed By Guest", 0);
        return view('security.guests.register')->with($data);
    }

     // call dropdown function in guest mode
	//load division level 5, 4, 3, 2, or 1
    public function divLevelGroupDD(Request $request) {
        $divLevel = (int) $request->input('div_level');
        $divHeadSpecific = (int) $request->input('div_head_specific');
        $parentID = $request->input('parent_id');
        $incInactive = !empty($request->input('inc_complete')) ? $request->input('inc_complete') : -1;
        $loadAll = $request->input('load_all');
        $divisions = [];
        $managerID = ($divHeadSpecific == 1) ? Auth::user()->person->id : 0;
        if ($divLevel === 5) {
            $divisions = DivisionLevelFive::where(function ($query) use($incInactive, $managerID) {
                if ($incInactive == -1) $query->where('active', 1);
                if ($managerID > 0) $query->where('manager_id', $managerID);
            })->get()
                ->sortBy('name')
                ->pluck('id', 'name');
        }
        elseif ($divLevel === 4) {
            if ($parentID > 0 && $loadAll == -1) $divisions = DivisionLevelFour::divsFromParent($parentID, $incInactive);
            elseif ($loadAll == 1) {
                $divisions = DivisionLevelFour::where(function ($query) use($incInactive, $managerID) {
                    if ($incInactive == -1) $query->where('active', 1);
                    if ($managerID > 0) $query->where('manager_id', $managerID);
                })->get()
                    ->sortBy('name')
                    ->pluck('id', 'name');
            }
        }
        elseif ($divLevel === 3) {
            if ($parentID > 0 && $loadAll == -1) $divisions = DivisionLevelThree::divsFromParent($parentID, $incInactive);
            elseif ($loadAll == 1) {
                $divisions = DivisionLevelThree::where(function ($query) use($incInactive, $managerID) {
                    if ($incInactive == -1) $query->where('active', 1);
                    if ($managerID > 0) $query->where('manager_id', $managerID);
                })->get()
                    ->sortBy('name')
                    ->pluck('id', 'name');
            }
        }
        elseif ($divLevel === 2) {
            if ($parentID > 0 && $loadAll == -1) $divisions = DivisionLevelTwo::divsFromParent($parentID, $incInactive);
            elseif ($loadAll == 1) {
                $divisions = DivisionLevelTwo::where(function ($query) use($incInactive, $managerID) {
                    if ($incInactive == -1) $query->where('active', 1);
                    if ($managerID > 0) $query->where('manager_id', $managerID);
                })->get()
                    ->sortBy('name')
                    ->pluck('id', 'name');
            }
        }
        elseif ($divLevel === 1) {
            if ($parentID > 0 && $loadAll == -1) $divisions = DivisionLevelOne::divsFromParent($parentID, $incInactive);
            elseif ($loadAll == 1) {
                $divisions = DivisionLevelOne::where(function ($query) use($incInactive, $managerID) {
                    if ($incInactive == -1) $query->where('active', 1);
                    if ($managerID > 0) $query->where('manager_id', $managerID);
                })->get()
                    ->sortBy('name')
                    ->pluck('id', 'name');
            }
        }
        
        return $divisions;
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
			'first_name' => 'required',
			'surname' => 'required',
			'id_number' => 'required',
			'cell_number' => 'required',
			'employee_number' => 'required',
			'chronic_diseases' => 'required',
			'transportation_method' => 'required',
			'email' => 'required',
			'password' => 'required',
			'division_level_5' => 'required',
			'division_level_4' => 'required',
            'email' => 'unique:users,email',
            'email' => 'unique:hr_people,email',
        ]);
        $validator->after(function ($validator) use($request) {
            $idNumber = $request->input('id_number');
			if (!empty($idNumber))
			{
				if(is_numeric($idNumber) && strlen($idNumber) == 13)
					$idNumber = $idNumber;
				else
					$validator->errors()->add('id_number', "The ID Number Must have thirteen digits.");
			}
        });
        if ($validator->fails()) {
            return redirect("/register-new-user")
                ->withErrors($validator)
                ->withInput();
        }

		$compDetails = CompanyIdentity::first();
		$iduration = !empty($compDetails->password_expiring_month) ? $compDetails->password_expiring_month : 0;
		$expiredDate = !empty($iduration) ? mktime(0,0,0,date('m')+ $iduration,date('d'),date('Y')) : 0;
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->type = 1;
        $user->status = 1;
		$user->password_changed_at = $expiredDate;
        $user->save();

        //exclude empty fields from query
        $personData = $request->all();
        foreach ($personData as $key => $value) {
            if (empty($personData[$key])) {
                unset($personData[$key]);
            }
        }
        //Save HR record
        $person = new HRPerson($personData);
        $person->status = 1;
        $person->employee_number = $personData['employee_number'];
        $user->addPerson($person);
        //Send email
        Mail::to("$user->email")->send(new ConfirmRegistration($user, $request->password));
		AuditReportsController::store('Security', 'New User Created', "Login Details Sent To User $user->email", 0);
		//Redirect to all usr view
        return redirect("/login");
    }
	// save demo user
	public function demoStore(Request $request)
	{
		//Validation
        $validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'surname' => 'required',
			'company' => 'required',
			'email' => 'required',
			'email' => 'unique:users,email',
            'email' => 'unique:hr_people,email',
        ]);
        $validator->after(function ($validator) use($request) {

        });
        if ($validator->fails()) {
            return redirect("/demo-user")
                ->withErrors($validator)
                ->withInput();
        }

		$compDetails = CompanyIdentity::first();
		$iduration = !empty($compDetails->password_expiring_month) ? $compDetails->password_expiring_month : 0;
		$expiredDate = !empty($iduration) ? mktime(0,0,0,date('m')+ $iduration,date('d'),date('Y')) : 0;
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make("1234567");
        $user->type = 1;
        $user->status = 1;
		$user->password_changed_at = $expiredDate;
        $user->save();

        //exclude empty fields from query
        $personData = $request->all();
        foreach ($personData as $key => $value) {
            if (empty($personData[$key])) {
                unset($personData[$key]);
            }
        }
        //Save HR record
        $person = new HRPerson($personData);
        $person->status = 1;
        $person->division_level_5 = 2;
        $person->division_level_4 = 2;
        $user->addPerson($person);
		// assign rights
		$userRights = new module_access();
		$userRights->user_id = $user->id;
		$userRights->module_id = 4;
		$userRights->access_level = 4;
		$userRights->save();
		
		$userRights = new module_access();
		$userRights->user_id = $user->id;
		$userRights->module_id = 1;
		$userRights->access_level = 2;
		$userRights->save();
		
        //Send email
        Mail::to("$user->email")->send(new ConfirmRegistration($user, $request->password));
		AuditReportsController::store('Security', 'New User Created', "Login Details Sent To User $user->email", 0);
		//Redirect to all usr view
		return back()->with('success_add', "Record has been successfully saved. Please use your registered email as username and Password: 1234567");
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
