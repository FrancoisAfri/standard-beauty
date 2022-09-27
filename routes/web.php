<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
/*
  Route::get('/', function () {
  return view('main_layout');
  });
  //Route::get('login', 'PagesController@login');
  //Route::get('/home', 'HomeController@index');
 */
//new user registration (Guest)
Route::get('register-new-user', 'NewUsersRegistrationController@index');
Route::get('demo-user', 'NewUsersRegistrationController@demo');
Route::post('demo-user/register', 'NewUsersRegistrationController@demoStore');
Route::post('create-new-account', 'NewUsersRegistrationController@store');
Route::get('/', 'DashboardController@index');
//Route::get('test', 'PagesController@testPage');
Route::get('/home', function () {
    return Redirect::action('DashboardController@index');
});

Auth::routes();

Route::get('view/{id}', 'CmsController@view');
Route::get('viewceo/{viewceo}', 'CmsController@viewceo');

#cms ratings
Route::get('rate/{id}/{cmsID}', 'CmsController@cmsratings');
// General Information
Route::get('general_information/view', 'CmsController@generalInformations');
// send quote
Route::post('advertising/send-quote', 'UsersController@sendQuotesDetails');

//Users related requests
Route::get('users', 'UsersController@index');
//Route::get('users/modules', 'UsersController@viewModules');
Route::get('users/create', 'UsersController@create');
Route::get('users/{user}/edit', 'UsersController@edit');
Route::get('users/profile', 'UsersController@profile');
Route::post('users', 'UsersController@store');
Route::post('users/search', 'UsersController@getSearch');
Route::post('users/search/activate', 'UsersController@activateUsers');
Route::post('users/{user}/pw', 'UsersController@updatePassword');
Route::post('users/{user}/upw', 'UsersController@updateUserPassword');
Route::patch('users/{user}', 'UsersController@update');
Route::get('users/modules', 'UsersController@modules');
Route::get('users/public-holiday', 'UsersController@publicHoliday');
Route::get('users/setup', 'UsersController@companySetup');
Route::post('users/public-holiday/delete/{holidayId}', 'UsersController@deleteHoliday');
Route::post('users/public-holiday', 'UsersController@saveHoliday');
Route::patch('/users/holiday_edit/{holiday}', 'UsersController@updateHoliday');
Route::post('users/setup/modules', 'UsersController@addmodules');
Route::post('users/setup/add_ribbon/{mod}', 'UsersController@addribbon');
Route::get('/users/ribbons/{mod}', 'UsersController@ribbonView');
Route::patch('/users/module_edit/{mod}', 'UsersController@editModule');

// Reset password
Route::get('password/expired', 'ExpiredPasswordController@expired');
Route::post('password/post_expired/{user}', 'ExpiredPasswordController@postExpired');

Route::get('users/approval', 'UsersController@usersApproval');
Route::post('users/users-approval', 'UsersController@approvalUsers');
Route::get('/users/reports', 'UsersController@reports');
Route::post('/users/get_users_access_report', 'UsersController@getEmployeesReport');
Route::post('/users/get_users_report_print', 'UsersController@getEmployeesReportPrint');
Route::post('/users/get_users_report', 'UsersController@getUsersReport');
Route::post('/users/get_users_print', 'UsersController@getUsersReportPrint');
Route::patch('/ribbon/{ribbon}', 'UsersController@editRibbon');
Route::get('/users/module_active/{mod}', 'UsersController@moduleAct');
Route::get('/users/module_access/{user}', 'UsersController@moduleAccess');
Route::get('/users/ribbon_active/{rib}', 'UsersController@ribbonAct');
Route::get('/user/delete/{user}', 'UsersController@deleteUser');
Route::get('users/users-access', 'SecurityController@usersAccess');
Route::post('users/users-access', 'SecurityController@getEmployees');
Route::post('users/update-users-access', 'SecurityController@updateRights');
Route::post('/users/access_save/{user}', 'UsersController@accessSave');
Route::get('users/reports_to', 'SecurityController@reportTo');
Route::post('/users/get_reports_to', 'SecurityController@getReportsTo');
Route::post('/users/update-report-to', 'SecurityController@updateReportsTo');
Route::get('/security/password-reset', 'SecurityController@resetPassword');
Route::post('/users/get_reset_password', 'SecurityController@getResetPassword');
Route::post('/users/update-reset-password', 'SecurityController@updatePassword');
Route::get('/security/assign-jobtitles', 'SecurityController@assignJobTitle');
Route::post('/security/get_job_titles', 'SecurityController@getJobTitle');
Route::post('/security/update_job_title', 'SecurityController@updateJobTitle');

//#Company Identity (company details: logo, theme color, etc)
Route::post('security/setup/company_details', 'CompanyIdentityController@saveOrUpdate');

// Employee Records Module
Route::get('hr/Admin', 'Hr_Admin@view');
Route::post('hr/searchemployees', 'Hr_Admin@search_employees');
Route::post('hr/user_active', 'Hr_Admin@activeEmployee');
Route::get('hr/active_user', 'Hr_Admin@cards');

Route::get('hr/upload', 'EmployeeUploadController@index');
Route::get('hr/job_title', 'EmployeeJobTitleController@index');
Route::post('hr/categories', 'EmployeeJobTitleController@categorySave');
Route::patch('hr/category_edit/{jobCategory}', 'EmployeeJobTitleController@editCategory');
Route::get('hr/jobtitles/{jobCategory}', 'EmployeeJobTitleController@jobView');
Route::get('/hr/category_active/{jobCategory}', 'EmployeeJobTitleController@categoryAct');
Route::get('/hr/job_title_active/{jobTitle}', 'EmployeeJobTitleController@jobtitleAct');
Route::post('hr/add_jobtitle/{jobCategory}', 'EmployeeJobTitleController@addJobTitle');
Route::patch('job_title/{jobTitle}', 'EmployeeJobTitleController@editJobTitle');
Route::post('hr/role/add/', 'HrController@addRole');
Route::patch('hr/role/edit/{role}', 'HrController@editRole');
Route::get('/hr/role_users/{user}', 'HrController@assignRole');
Route::get('/hr/role/activate/{role}', 'HrController@roleAct');
Route::post('hr/roles-access/{user}', 'HrController@userRoleSave');
// Audit Module
Route::get('audit/reports', 'AuditReportsController@index');
Route::post('audits', 'AuditReportsController@getReport');
Route::post('audits/print', 'AuditReportsController@printreport');

//Employees Documents Module
Route::get('/hr/emp_document', 'EmployeeDocumentsController@viewDoc');
Route::get('/hr/{user}/edit', 'EmployeeDocumentsController@editUser');
Route::get('/hr/doc_results', 'EmployeeDocumentsController@SearchResults');

Route::post('/hr/emp_doc/Search', 'EmployeeDocumentsController@Searchdoc');
Route::post('/hr/emp_document/upload_doc', 'EmployeeDocumentsController@uploadDoc');
Route::post('/hr/emp_qual/Search', 'EmployeeDocumentsController@Searchqul');
Route::post('/hr/emp_search/Search', 'EmployeeDocumentsController@SearchEmp');

//Employees Qualifications Module
Route::get('/hr/emp_qualification', 'EmployeeQualificationsController@viewDoc');
Route::post('/hr/emp_qual/Search', 'EmployeeQualificationsController@Searchqul');
Route::post('/hr/upload/{docs}', 'EmployeeQualificationsController@uploadDocs');

//Employees upload
Route::get('/employee_upload', 'EmployeeUploadController@index');
Route::post('/hr/employees_upload', 'EmployeeUploadController@store');

//Employee Search
Route::get('/hr/emp_search', 'EmployeeSearchController@index');
Route::post('/hr/users_search', 'EmployeeSearchController@getSearch');

// Company setup Module
Route::get('/hr/company_setup', 'EmployeeCompanySetupController@viewLevel');
Route::post('/hr/firstleveldiv/add/{divLevel}', 'EmployeeCompanySetupController@addLevel');
Route::patch('/hr/company_edit/{divLevel}/{childID}', 'EmployeeCompanySetupController@updateLevel');
Route::get('/hr/company_edit/{divLevel}/{childID}/activate', 'EmployeeCompanySetupController@activateLevel');
Route::get('/hr/child_setup/{level}/{parent_id}', 'EmployeeCompanySetupController@viewchildLevel');
Route::patch('/hr/firstchild/{parentLevel}/{childID}', 'EmployeeCompanySetupController@updateChild');
Route::post('/hr/firstchild/add/{parentLevel}/{parent_id}', 'EmployeeCompanySetupController@addChild');
Route::get('/hr/firstchild/{parentLevel}/{childID}/activate', 'EmployeeCompanySetupController@activateChild');
//Survey
Route::get('survey/reports', 'SurveysController@indexReports');
Route::get('survey/question_activate/{question}', 'SurveysController@actDeact');
Route::get('survey/questions', 'SurveysController@questionsLists');
Route::get('survey/rating-links', 'SurveysController@indexRatingLinks');
Route::post('survey/add_question', 'SurveysController@saveQuestions');
Route::post('survey/reports', 'SurveysController@getReport');
Route::post('survey/reports/print', 'SurveysController@printReport');
Route::patch('/survey/question_update/{question}', 'SurveysController@updateQuestions');

// Company setup Module
Route::get('/hr/setup', 'HrController@showSetup');
Route::patch('/hr/grouplevel/{groupLevel}', 'HrController@updateGroupLevel');
Route::get('/hr/grouplevel/activate/{groupLevel}', 'HrController@activateGroupLevel');
// Contacts
//contacts/search
// CMS
Route::get('cms/viewnews', 'CmsController@addnews');
Route::post('cms/crm_news', 'CmsController@addcmsnews');
Route::get('cms/viewnews/{news}', 'CmsController@viewnews');
Route::post('cms/updatenews', 'CmsController@updatenews');
Route::get('cms/cmsnews_act/{news}', 'CmsController@newsAct');
Route::get('/cms/news/{news}/delete', 'CmsController@deleteNews');
Route::patch('cms/{news}/update', 'CmsController@updatContent');

// cms search
Route::get('cms/search', 'CmsController@search');
Route::post('cms/search/CeoNews', 'CmsController@cmsceonews');
Route::post('cms/search/CamponyNews', 'CmsController@CamponyNews');

// cms Reports
Route::get('cms/cms_report', 'CmsController@cms_report');
Route::post('cms/cms_news_ranking', 'CmsController@cms_rankings');
Route::get('cms/cms_newsrankings/{news}', 'CmsController@cms_Star_rankings');

//General Use (API)
Route::get('api/vehiclestatusgraphdata', 'VehicleDashboard@vehicleStatus')->name('vehiclestatus');
Route::post('api/productCategorydropdown', 'DropDownAPIController@productCategoryDDID')->name('pcdropdown');
Route::post('api/jobcategorymodeldropdown', 'DropDownAPIController@jobcategorymomdelDDID')->name('jcmdropdown');
Route::post('api/vehiclemodeldropdown', 'DropDownAPIController@vehiclemomdeDDID')->name('Vmmdropdown');
Route::post('api/divisionsdropdown', 'DropDownAPIController@divLevelGroupDD')->name('divisionsdropdown');
Route::post('api/divisionsdropdownGuest', 'NewUsersRegistrationController@divLevelGroupDD')->name('divisionsdropdownguest');
Route::post('api/hrpeopledropdown', 'DropDownAPIController@hrPeopleDD')->name('hrpeopledropdown');
Route::post('api/kpadropdown', 'DropDownAPIController@kpaDD')->name('kpadropdown');
Route::post('api/stockdropdown', 'DropDownAPIController@stockLevelGroupDD')->name('stockdropdown');
Route::get('api/emp/{empID}/monthly-performance', 'AppraisalGraphsController@empMonthlyPerformance');
Route::get('api/screening/view-questions/{viewID}', 'ScreeningController@viewQuestions');
Route::get('api/divlevel/{divLvl}/group-performance', 'AppraisalGraphsController@divisionsPerformance');
Route::get('api/divlevel/{divLvl}/parentdiv/{parentDivisionID}/group-performance', 'AppraisalGraphsController@divisionsPerformance');
Route::get('api/divlevel/{divLvl}/parentdiv/{parentDivisionID}/manager/{managerID}/group-performance', 'AppraisalGraphsController@divisionsPerformance');
Route::get('api/divlevel/{divLvl}/div/{divID}/emps-performance', 'AppraisalGraphsController@empListPerformance');
Route::get('api/availableperks', 'AppraisalGraphsController@getAvailablePerks')->name('availableperks');
Route::get('api/appraisal/emp/topten/{divLvl}/{divID}', 'AppraisalGraphsController@getTopTenEmployees')->name('toptenemp');
Route::get('api/appraisal/emp/bottomten/{divLvl}/{divID}', 'AppraisalGraphsController@getBottomTenEmployees')->name('bottomtenemp');
Route::get('api/appraisal/staffunder/{managerID}', 'AppraisalGraphsController@getSubordinates')->name('staffperform');
Route::get('api/leave/availableBalance/{hr_id}/{levID}', 'LeaveApplicationController@availableDays');
Route::get('api/leave/availableBalance/{hr_id}/{levID}', 'LeaveApplicationController@availableDays');
Route::get('api/leave/calleavedays/{dateFrom}/{dateTo}', 'LeaveApplicationController@calculatedays');

Route::get('api/tasks/emp/meetingTask/{divLvl}/{divID}', 'EmployeeTasksWidgetController@getMeetingEmployees')->name('meetingTasksEmployee');
Route::get('api/tasks/emp/inductionTask/{divLvl}/{divID}', 'EmployeeTasksWidgetController@getInductionEmployees')->name('inductionTasksEmployee');
Route::get('api/tasks/{task}/duration/{timeInSeconds}', 'TaskTimerController@updateDuration');
Route::get('api/tasks/{task}/get-duration', 'TaskTimerController@getDuration');
Route::post('api/contact-people-dropdown', 'DropDownAPIController@contactPeopleDD')->name('contactsdropdown');

Route::group(['prefix' => 'customer', 'namespace' => 'customer', 'middleware' => ['auth']], function () {
    Route::resource('/', CustomerManagementController::class);
    /**
     * custom CustomerManagementController routes
     */
    Route::get(
        'search', 'CustomerManagementController@index')
        ->name('customer.search');
	Route::patch(
        'act/{contact}', 'CustomerManagementController@activate')
        ->name('customer.activate');
	Route::delete(
        'customer/{contact}', 'CustomerManagementController@destroy')
        ->name('customer.destroy');
	Route::get('show/{contact}', 'CustomerManagementController@show')
        ->name('customer.show');
	Route::patch('update/{contact}', 'CustomerManagementController@update')
        ->name('customer.update');
   
});

Route::group(['prefix' => 'routine', 'namespace' => 'routine', 'middleware' => ['auth']], function () {
    Route::resource('/', RoutineBuilderController::class);
    /**
     * custom RoutineBuilderController routes
     */

    Route::get('search', 'RoutineBuilderController@index')
        ->name('routine.search');
	Route::get(
        'act/{goal}', 'RoutineBuilderController@activate')
        ->name('routine.goal.activate');
	Route::delete(
        'routine.goal.destroy/{goal}', 'RoutineBuilderController@destroy')
        ->name('routine.goal.destroy');
	Route::get('show/{goal}', 'RoutineBuilderController@show')
        ->name('routine.show');
	Route::patch('goal/update/{goal}', 'RoutineBuilderController@update')
        ->name('routine.goal.update');
});