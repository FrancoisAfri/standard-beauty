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
}
