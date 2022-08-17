<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\HRPerson;
use App\Http\Requests;
use App\DivisionLevelOne;
use App\DivisionLevelTwo;
use App\DivisionLevelThree;
use App\DivisionLevelFour;
use App\DivisionLevelFive;
use App\TopLevel;
use App\DivisionLevel;

class EmployeeCompanySetupController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewLevel()
    {
        //get the highest active level
        $childLevelname = null;
        $division_types = DB::table('division_setup')->orderBy('level', 'desc')->get();
        $employees = HRPerson::where('status', 1)->orderBy('first_name', 'asc')->orderBy('surname', 'asc')->get();
        $highestLvl = DivisionLevel::where('active', 1)->orderBy('level', 'desc')->limit(1)->get()->first()->load('divisionLevelGroup.manager','divisionLevelGroup.hrManager','divisionLevelGroup.payrollOfficer');
        $lowestactiveLvl = DivisionLevel::where('active', 1)->orderBy('level', 'asc')->limit(1)->get()->first()->level;
        if ($highestLvl->level > $lowestactiveLvl) {
            $childLevelname = DivisionLevel::where('level', $highestLvl->level - 1)->get()->first()->plural_name;
        }
        $data['division_types'] = $division_types;
        $data['employees'] = $employees;
        $data['highestLvl'] = $highestLvl;
        $data['lowestactiveLvl'] = $lowestactiveLvl;
        $data['childLevelname'] = $childLevelname;
        $data['page_title'] = "Setup";
        $data['page_description'] = "Company Records";
        $data['breadcrumb'] = [
            ['title' => 'HR', 'path' => '/hr', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Setup', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Company Setup';
        $data['active_rib'] = 'Levels';

        AuditReportsController::store('Employee records', 'Setup Search Page Accessed', "Actioned By User", 0);
        return view('hr.company_setup')->with($data);
    }

    public function addLevel(Request $request, DivisionLevel $divLevel)
    {
        $this->validate($request, [
            'manager_id' => 'required',
            'name' => 'required',
        ]);
        $firstLevelData = $request->all();

        if ($divLevel->level == 5) {
            $childDiv = new DivisionLevelFive($firstLevelData);
            $childDiv->division_level_id = 5;
        } elseif ($divLevel->level == 4) {
            $childDiv = new DivisionLevelFour($firstLevelData);
            $childDiv->division_level_id = 4;
        } elseif ($divLevel->level == 3) {
            $childDiv = new DivisionLevelThree($firstLevelData);
            $childDiv->division_level_id = 3;
        } elseif ($divLevel->level == 2) {
            $childDiv = new DivisionLevelTwo($firstLevelData);
            $childDiv->division_level_id = 2;
        } elseif ($divLevel->level == 1) {
            $childDiv = new DivisionLevelOne($firstLevelData);
            $childDiv->division_level_id = 1;
        }
        $childDiv->active = 1;
        $divLevel->addDivisionLevelGroup($childDiv);

        AuditReportsController::store('Employee records', 'Employee Group Level Modified', "Actioned By User", 0);
    }

    public function activateLevel(DivisionLevel $divLevel, $childID)
    {
        if ($divLevel->level == 5) {
            $childDiv = DivisionLevelFive::find($childID);
        } elseif ($divLevel->level == 4) {
            $childDiv = DivisionLevelFour::find($childID);
        } elseif ($divLevel->level == 3) {
            $childDiv = DivisionLevelThree::find($childID);
        } elseif ($divLevel->level == 2) {
            $childDiv = DivisionLevelTwo::find($childID);
        } elseif ($divLevel->level == 1) {
            $childDiv = DivisionLevelOne::find($childID);
        }
        if ($childDiv->active == 1) $stastus = 0;
        else $stastus = 1;
        $childDiv->active = $stastus;
        $childDiv->update();
        AuditReportsController::store('Employee records', 'division level active status changed', "Edited by User", 0);
        return back();
    }

    public function updateLevel(Request $request, DivisionLevel $divLevel, $childID)
    {
        //$user = Auth::user()->load('person');
        $this->validate($request, [
            'name' => 'required',
            'manager_id' => 'numeric|required',
        ]);

        if ($divLevel->level == 5) {
            $childDiv = DivisionLevelFive::find($childID);
            $childDiv->update($request->all());
        } elseif ($divLevel->level == 4) {
            $childDiv = DivisionLevelFour::find($childID);
            $childDiv->update($request->all());
        } elseif ($divLevel->level == 3) {
            $childDiv = DivisionLevelThree::find($childID);
            $childDiv->update($request->all());
        } elseif ($divLevel->level == 2) {
            $childDiv = DivisionLevelTwo::find($childID);
            $childDiv->update($request->all());
        } elseif ($divLevel->level == 1) {
            $childDiv = DivisionLevelOne::find($childID);
            $childDiv->update($request->all());
        }
        AuditReportsController::store('Employee records', 'division level Informations Edited', "Edited by User", 0);
        return response()->json();
    }

    public function viewchildLevel($parentLevel, $parent_id)
    {
        //   $childLevel = null;
        $intCurrentLvl = 0;
        if ($parentLevel == 5) {
            $parentDiv = DivisionLevelFive::find($parent_id);
            $childDiv = $parentDiv->childDiv;
            $intCurrentLvl = 4;
        } elseif ($parentLevel == 4) {
            $parentDiv = DivisionLevelFour::find($parent_id);
            $childDiv = $parentDiv->childDiv;
            $intCurrentLvl = 3;
        } elseif ($parentLevel == 3) {
            $parentDiv = DivisionLevelThree::find($parent_id);
            $childDiv = $parentDiv->childDiv;
            $intCurrentLvl = 2;
        } elseif ($parentLevel == 2) {
            $parentDiv = DivisionLevelTwo::find($parent_id);
            $childDiv = $parentDiv->childDiv;
            $intCurrentLvl = 1;
        } elseif ($parentLevel == 1) {
            $parentDiv = DivisionLevelOne::find($parent_id);
            $childDiv = null;
            $intCurrentLvl = 0;
        }
		$employees = HRPerson::where('status', 1)->orderBy('first_name', 'asc')->orderBy('surname', 'asc')->get();
        $lowestactiveLvl = DivisionLevel::where('active', 1)->orderBy('level', 'asc')->limit(1)->get()->first()->level;
        if ($parentLevel > $lowestactiveLvl) {
            $childLevel = DivisionLevel::where('level', $parentLevel - 1)->get()->first();
            $curLvlChild = DivisionLevel::where('level', $childLevel->level - 1)->get()->first();
        }
        $data['childDiv'] = $childDiv;
        $data['employees'] = $employees;
        $data['parentLevel'] = $parentLevel;
        $data['parentDiv'] = $parentDiv;
        $data['lowestactiveLvl'] = $lowestactiveLvl;
        $data['childLevel'] = $childLevel;
        $data['curLvlChild'] = $curLvlChild;
        $data['page_title'] = "Company Setup";
        $data['page_description'] = "Company records";
        $data['breadcrumb'] = [
            ['title' => 'HR', 'path' => '/hr', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Setup', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Employee records';
        $data['active_rib'] = 'Levels';
        AuditReportsController::store('Employee records', 'Setup Search Page Accessed', "Actioned By User", 0);
        return view('hr.child_setup')->with($data);
    }

    public function addChild(Request $request, $parentLevel, $parent_id)
    {
        $this->validate($request, [
            'manager_id' => 'required',
            'name' => 'required',
        ]);
        $childData = $request->all();
        if ($parentLevel == 5) {
            $parentDiv = DivisionLevelFive::find($parent_id);
            $childDiv = new DivisionLevelFour($childData);
            $childDiv->division_level_id = 4;
        } elseif ($parentLevel == 4) {
            $parentDiv = DivisionLevelFour::find($parent_id);
            $childDiv = new DivisionLevelThree($childData);
            $childDiv->division_level_id = 3;
        } elseif ($parentLevel == 3) {
            $parentDiv = DivisionLevelThree::find($parent_id);
            $childDiv = new DivisionLevelTwo($childData);
            $childDiv->division_level_id = 2;
        } elseif ($parentLevel == 2) {
            $parentDiv = DivisionLevelTwo::find($parent_id);
            $childDiv = new DivisionLevelOne($childData);
            $childDiv->division_level_id = 1;
        } elseif ($parentLevel == 1) {
            $parentDiv = DivisionLevelOne::find($parent_id);
            $childDiv = null;
        }
        $childDiv->active = 1;
        $parentDiv->addChildDiv($childDiv);
        AuditReportsController::store('Employee records', 'Employee Group Level Modified', "Actioned By User", 0);
    }

    public function updateChild(Request $request, $parentLevel, $childID)
    {
        $this->validate($request, [
            'manager_id' => 'required',
            'name' => 'required',
        ]);
        $childData = $request->all();
        if ($parentLevel == 5) {
            $childDiv = DivisionLevelFive::find($childID);
            $childDiv->update($request->all());
        } elseif ($parentLevel == 4) {
            $childDiv = DivisionLevelFour::find($childID);
            $childDiv->update($request->all());
        } elseif ($parentLevel == 3) {
            $childDiv = DivisionLevelThree::find($childID);
            $childDiv->update($request->all());
        } elseif ($parentLevel == 2) {
            $childDiv = DivisionLevelTwo::find($childID);
            $childDiv->update($request->all());
        } elseif ($parentLevel == 1) {
            $childDiv = DivisionLevelOne::find($childID);
            $childDiv->update($request->all());
        }
        AuditReportsController::store('Employee records', 'Employee Group Level Modified', "Actioned By User", 0);
        return response()->json();
    }


    public function activateChild($parentLevel, $childID)
    {
        if ($parentLevel == 5) {
            $childDiv = DivisionLevelFive::find($childID);
        } elseif ($parentLevel == 4) {
            $childDiv = DivisionLevelFour::find($childID);
        } elseif ($parentLevel == 3) {
            $childDiv = DivisionLevelThree::find($childID);
        } elseif ($parentLevel == 2) {
            $childDiv = DivisionLevelTwo::find($childID);
        } elseif ($parentLevel == 1) {
            $childDiv = DivisionLevelOne::find($childID);
        }

        if ($childDiv->active == 1) $stastus = 0;
        else $stastus = 1;
        $childDiv->active = $stastus;
        $childDiv->update();
        AuditReportsController::store('Employee records', 'division level active satus changed', "Edited by User", 0);
        return back();
    }

}