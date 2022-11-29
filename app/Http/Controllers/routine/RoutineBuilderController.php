<?php

namespace App\Http\Controllers\routine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Traits\BreadCrumpTrait;
use App\Traits\StoreImageTrait;
use App\Traits\uploadFilesTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\AuditReportsController;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Mail;
use App\Goals;
use App\Routines;
use App\RoutineLink;
use App\RoutineSetup;
use App\Affirmations;
use App\Mail\ConfirmRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RoutineBuilderController extends Controller
{
	use BreadCrumpTrait, StoreImageTrait, uploadFilesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = !empty($request['status_id']) ? $request['status_id'] : 1;
        $goals = Goals::getAllGoals($status);

        $data = $this->breadCrump(
            "Routine Builder Management",
            "Manage Routine", "fa fa-lock",
            "Routine Builder Management",
            "Routine Builder Management",
            "routine/search",
            "Routine Builder Management",
            "Routine Builder Management Search"
        );

        $data['goals'] = $goals;
        $data['status'] = $status;

        AuditReportsController::store(
            'Routine Builder Management',
            'Routine Builder Management Search Page Accessed',
            "Actioned By User",
            0
        );
        return view('routine.manage.view_goals')->with($data);
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
		
		$goalData = $request->all();

		$goal = new Goals($goalData);
        $goal->status = 1;
		$goal->save();
        AuditReportsController::store('Routine Builder Management', 'Goal Added', "Added By User", 0);;
        return response()->json();
    }
	// save routine
	public function saveRoutine (Request $request, Goals $goal)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);
		
		$routine = new Routines($request->all());
        $routine->status = 1;
        $routine->goal_id = $goal->id;
		$routine->save();
		
		# pictures
		// setup
		$setup = RoutineSetup::whereNotNull('document_root')->first();
        $numFiles = $index = 0;
        $totalFiles = !empty($request['total_files']) ? $request['total_files'] : 0;
        $Extensions = array('png', 'jpg');

        $Files = isset($_FILES['picture']) ? $_FILES['picture'] : array();
        while ($numFiles != $totalFiles) {
            $index++;
            $hyper_link = $request->hyper_link[$index];
            if (isset($Files['name'][$index]) && $Files['name'][$index] != '') {
                $fileName = $routine->id . '_' . $Files['name'][$index];
                $Explode = array();
                $Explode = explode('.', $fileName);
                $ext = end($Explode);
                $ext = strtolower($ext);
                if (in_array($ext, $Extensions)) {
                    if (!is_dir("$setup->document_root")) mkdir("$setup->document_root", 0775);
                    move_uploaded_file($Files['tmp_name'][$index], "$setup->document_root".'/' . $fileName) or die('Could not move file!');

                    $RoutineLink = new RoutineLink();
                    $RoutineLink->routine_id = $routine->id;
                    $RoutineLink->hyper_link = $hyper_link;
                    $RoutineLink->picture = $fileName;
                    $RoutineLink->status = 1;
                    $RoutineLink->save();
                }
            }
            $numFiles++;
        }
		
        AuditReportsController::store('Routine Builder Management', 'Routine Added', "Added By User", 0);;
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Goals $goal)
    {
		//return $goal;
		$status = !empty($request['status_id']) ? $request['status_id'] : 1;
		$goal_id = !empty($request['goal_id']) ? $request['goal_id'] : 0;
        $goals = Goals::
				 orderBy('title', 'asc')
				 ->get();
		if (!empty($goal_id))
		{
			$goal = Goals::where('id',$goal_id)->first();
			$routines = Routines::getAllRoutines($status, $goal_id);
		}
		else
		{
			$routines = Routines::getAllRoutines($status, $goal->id);
			$goal_id = $goal->id; 
		}
		//return $routines;
        $data = $this->breadCrump(
            "Routine Builder Management",
            "Manage Clients", "fa fa-lock",
            "Routine Builder Management",
            "Routine Builder Management",
            "routine/search",
            "Routine Builder Management",
            "View Routine"
        );

        $data['routines'] = $routines;
        $data['goal_id'] = $goal_id;
        $data['status'] = $status;
        $data['goal'] = $goal;
        $data['goals'] = $goals;
		
        AuditReportsController::store(
            'Routine Builder Management',
            'Routine Details Accessed',
            "Accessed By User",
            0
        );
        return view('routine.manage.routine')->with($data);
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
    public function update(Request $request, Goals $goal)
    {
		//<a href="{{ route('student.detail', ['id' => 5, 'parameter' => 'advanced-web-hindi']) }}">Student detail</a>
		$goal->update($request->all());

        Alert::toast('Record Updated Successfully ', 'success');

        AuditReportsController::store('Routine Builder Management', 'Goal Details Edited', "Edited By User", 0);
        return response()->json();
    }
	// update routine
	public function updateRoutine(Request $request, Routines $routine)
    {
		$routine->update($request->all());

        Alert::toast('Record Updated Successfully ', 'success');

        AuditReportsController::store('Routine Builder Management', 'Goal Details Edited', "Edited By User", 0);
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goals $goal)
    {
        $goal->delete();
		AuditReportsController::store('Routine Builder Management', 'Goal Deleted', "Deleted By User", 0);;
        return redirect()->route('index')->with('status', 'Goal Deleted!');
    } 
	// delete routine
	public function destroyRoutine(Routines $routine)
    {
		$goalID = $routine->goal_id;
        $routine->delete();
		AuditReportsController::store('Routine Builder Management', 'Routine Deleted', "Deleted By User", 0);;
        return redirect()->route('routine.show',$routine->goal_id)->with('status', 'Routine Deleted!');
    }
	
	// activate and deactivate goal
	public function activate(Goals $goal)
    {
		$goal->status = !empty($goal->status) && $goal->status == 2 ? 1 : 2;
		$goal->update();
		
		Alert::toast('Status changed', 'Status changed Successfully');

        AuditReportsController::store('Routine Builder Management', 'Routine Builder Status Changed', " Changed By User", 0);
        return redirect()->route('index')->with('status', 'Goal Status Changed!');
    }
	// activate and deactivate routine
	public function activateRoutine(Routines $routine)
    {
		$routine->status = !empty($routine->status) && $routine->status == 2 ? 1 : 2;
		$routine->update();
		
		Alert::toast('Status changed', 'Status changed Successfully');

        AuditReportsController::store('Routine Builder Management', 'Routine Builder Status Changed', " Changed By User", 0);
        return redirect()->route('routine.show',$routine->goal_id)->with('status', 'Goal Status Changed!');
    }
	// setup
	public function setup()
    {
		
		$setup = RoutineSetup::whereNotNull('document_root')->first();
		if (empty($setup)) 
		{
			$routine = new RoutineSetup();
			$routine->document_root = 'test';
			$routine->save();
		}
        $data = $this->breadCrump(
            "Routine Builder Management",
            "Setup", "fa fa-lock",
            "Routine Builder Management",
            "Routine Builder Management",
            "routine/setup",
            "Routine Builder Management",
            "View Routine"
        );
		$data['setup'] = $setup;
		AuditReportsController::store('Routine Builder Management', 'Setup Page accessed', "Accessed By User", 0);
		return view('routine.manage.setup')->with($data);
    }
	// save setup
	public function saveSetup(Request $request,RoutineSetup $setup)
    {
		$config = $request->all();
        unset($config['_token']);
		$setup->document_root = !empty($config['document_root']) ? $config['document_root'] : '';
        $setup->update();

		AuditReportsController::store('Routine Builder Management', 'Setup Saved', "Saved By User", 0);
		return redirect()->route('routine.setup')->with('status', 'Setup Saved !');
    }
	// affirmation
	public function affirmation(Request $request)
    {
        $status = !empty($request['status_id']) ? $request['status_id'] : 1;
        $affirmations = Affirmations::getAffirmations($status);

        $data = $this->breadCrump(
            "Routine Builder Management",
            "Affirmation", "fa fa-lock",
            "Routine Builder Management",
            "Routine Builder Management",
            "routine/search",
            "Routine Builder Management",
            "Routine Builder Management Search"
        );

        $data['affirmations'] = $affirmations;
        $data['status'] = $status;

        AuditReportsController::store(
            'Routine Builder Management',
            'Affirmations Page Accessed',
            "Actioned By User",
            0
        );
        return view('routine.manage.view_affirmations')->with($data);
    }
	/// save affirmation
	// save routine
	public function saveAffirmation (Request $request)
    {
        $this->validate($request, [
            'affirmation' => 'required',
        ]);
		
		$Affirmations = new Affirmations($request->all());
        $Affirmations->status = 1;
		$Affirmations->save();
		
        AuditReportsController::store('Routine Builder Management', 'Affirmation Added', "Added By User", 0);;
        return response()->json();
    }
	// update affirmation
		// update routine
	public function updateAffirmation(Request $request, Affirmations $affirmation)
    {
		$this->validate($request, [
            'affirmation' => 'required',
        ]);
		
		$affirmation->update($request->all());

        Alert::toast('Record Updated Successfully ', 'success');

        AuditReportsController::store('Routine Builder Management', 'Affirmations Details Edited', "Edited By User", 0);
        return response()->json();
    }
	//delete
	public function destroyaffirmation(Affirmations $affirmation)
    {
        $affirmation->delete();
		AuditReportsController::store('Routine Builder Management', 'Affirmation Deleted', "Deleted By User", 0);;
        return redirect()->route('routine.affirmation')->with('status', 'Goal Deleted!');
    }
	
	// activate and deactivate affirmation
	public function activateAffirmation(Affirmations $affirmation)
    {
		$affirmation->status = !empty($affirmation->status) && $affirmation->status == 2 ? 1 : 2;
		$affirmation->update();
		
		Alert::toast('Status changed', 'Status changed Successfully');

        AuditReportsController::store('Routine Builder Management', 'Affirmation Status Changed', " Changed By User", 0);
        return redirect()->route('routine.affirmation')->with('status', 'Goal Status Changed!');
    }
}
