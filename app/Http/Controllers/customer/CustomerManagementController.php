<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
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
use App\contacts;
use App\contacts_users;
use App\Mail\ConfirmRegistration;
use Illuminate\Support\Facades\Hash;

class CustomerManagementController extends Controller
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
        $customers = contacts::getAllCustomers($status);

        $data = $this->breadCrump(
            "Customer Management",
            "Manage Clients", "fa fa-lock",
            "Customer Management",
            "Customer Management",
            "customer/search",
            "Customer Management",
            "Customer Management Search"
        );

        $data['customers'] = $customers;
        $data['status'] = $status;

        AuditReportsController::store(
            'Customer Management',
            'Customer Management Search Page Accessed',
            "Actioned By User",
            0
        );

        return view('contacts.manageClient.view_customer')->with($data);
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
            'firstname' => 'required',
            'surname' => 'required',
            'email' => 'bail|unique:contacts,email',
            'cell_number' => 'unique:contacts,cell_number',
        ]);
		
		$contactsData = $request->all();

        //Cell number formatting
        $contactsData['cell_number'] = str_replace(' ', '', $contactsData['cell_number']);
        $contactsData['cell_number'] = str_replace('-', '', $contactsData['cell_number']);
        $contactsData['cell_number'] = str_replace('(', '', $contactsData['cell_number']);
        $contactsData['cell_number'] = str_replace(')', '', $contactsData['cell_number']);
		
		$person = new contacts($contactsData);
        $person->cell_number = (empty($person->cell_number)) ? null : $person->cell_number;
        $person->status = 1;
		$contacts_users = new contacts_users;
		$contacts_users->email = $request->email;
		$generatedPassword = str_random(10);
		$contacts_users->password = Hash::make($generatedPassword);
		$contacts_users->status = 1;
		$contacts_users->save();

		//Save client record
		$contacts_users->addPerson($person);
		// save picture 
        $this->verifyAndStoreImage('customer/images', 'picture', $person, $request);

		//Send email to client
	    Mail::to($contacts_users->email)->send(new ConfirmRegistration($contacts_users, $generatedPassword));

        AuditReportsController::store('Customer Management', 'Customer Added', "Accessed By User", 0);;
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(contacts $contact)
    {
        $data = $this->breadCrump(
            "Customer Management",
            "Manage Clients", "fa fa-lock",
            "Customer Management",
            "Customer Management",
            "customer/search",
            "Customer Management",
            "Customer Management Search"
        );
		$contact = $contact->load('medication');
//return  $contact;
        $data['contact'] = $contact;
		
        AuditReportsController::store(
            'Customer Management',
            'Customer Details Accessed',
            "Accessed By User",
            0
        );
        return view('contacts.manageClient.index')->with($data);
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
    public function update(Request $request, $contact)
    {
        //exclude token, method and command fields from query.
        $person = $request->all();
        unset($person['_token'], $person['_method'], $person['command']);

        //Cell number formatting
        $person['cell_number'] = str_replace(' ', '', $person['cell_number']);
        $person['cell_number'] = str_replace('-', '', $person['cell_number']);
        $person['cell_number'] = str_replace('(', '', $person['cell_number']);
        $person['cell_number'] = str_replace(')', '', $person['cell_number']);

        //exclude empty fields from query
        foreach ($person as $key => $value) {
            if (empty($person[$key])) {
                unset($person[$key]);
            }
        }
		$contact = contacts::find($contact);
		$contact->cell_number = (empty($person->cell_number)) ? null : $person->cell_number;
        $contact->update($person);
        //TODO FIX THE UPLOAD
        $this->verifyAndStoreImage('customer/images', 'picture', $contact, $request);

        Alert::toast('Record Updated Successfully ', 'success');

        AuditReportsController::store('Customer Management', 'Customer Details Edited', "Edited By User", 0);;
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	 
	 // delete customer
    public function destroy(contacts $contact): RedirectResponse
    {
		$contactusers = contacts_users::find($contact->user_id);
        $contactusers->delete();
        $contact->delete();
        return redirect()->route('index')->with('status', 'Customer Deleted!');
    }
	// activate and deactivate customer
	public function activate(Request $request, $contact)
    {
		$contact = contacts::find($contact);
        $contact->status = !empty($request->status) ? 1 : 0;
        $contact->update();
		//update contact user 
		$contacts_users = contacts_users::find($contact->user_id);
		$contacts_users->status = !empty($request->status) ? 1 : 0;
		$contacts_users->update();
        
		Alert::toast('Status changed', 'Status changed Successfully');

        AuditReportsController::store('Customer Management', 'Customer Status Changed', "Customer Status Changed By User", 0);
        return response()->json();
    }
}