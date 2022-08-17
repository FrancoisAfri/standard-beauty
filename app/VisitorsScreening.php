<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorsScreening extends Model
{
    //Specify the table name
    public $table = 'visitors_screenings';
    
    // Mass assignable fields
    protected $fillable = [
        'question_1', 'question_2', 'question_3', 'question_4', 'question_5'
		,'question_6', 'question_7', 'question_8',
        'id_number', 'captured_id', 'client_name', 'cell_number'
		, 'company_id', 'site_id',
        'covid_admin', 'comment', 'temperature', 'date_captured', 'new_id_number'
        
    ];
	
	//Relationship hr_person and user
    public function administrtor() {
        return $this->belongsTo(HRPerson::class, 'covid_admin');
    }
	//Relationship hr_person and user
    public function company() {
        return $this->belongsTo(DivisionLevelFive::class, 'company_id');
    }
	//Relationship hr_person and user
    public function site() {
        return $this->belongsTo(DivisionLevelFour::class, 'site_id');
    }
}
