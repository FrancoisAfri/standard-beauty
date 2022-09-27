<div class="col-lg-6 col-sm-6 pull-left">
    <br>
    <br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-hover">
                <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>Firstname</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            {{$contact->firstname}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>Surname</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            {{$contact->surname}}
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>Email</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            {{$contact->email}}
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong> Phone Number</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
						{{ (!empty( $contact->cell_number)) ?  $contact->cell_number : ''}} 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>Address</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
						{{ (!empty( $contact->address)) ?  $contact->address : ''}}
                        </div>
                    </td>
                </tr>
				<tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>
                                Status
                            </strong>
                        </div>
                    </td>
                    <td>
						<div class="col-md-6">
							{{ (!empty( $contact->status) && $contact->status == 1 ) ?  'Active' : 'Inactive'}}
						</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>On Medication</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
						 {{ (!empty( $contact->on_medication) && $contact->on_medication == 1 ) ?  'Yes' : 'No'}}
                        </div>
                    </td>
                </tr>
                <tr><td colspan="2" style="text-align: center;"><strong>Medications</strong></td></tr>
				@foreach($contact->medication as $medication)
					<tr>
						<td style="text-align: center;" colspan="2">
							
							{{$medication->medication}}
							
						</td>
					</tr>
				@endforeach
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <strong>Change Status</strong>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            <button type="button" id="efit_status" class="btn btn-secondary pull-right btn-sm"
                                    data-toggle="modal" data-target="#change-asset_status-modal"
                                    data-id="{{ $contact->id }}"
                                    data-name="{{ $contact->status}}">Change Status
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6 col-sm-6">
    <br>
    <br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $contact->name}}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> 

            <img src="{{ asset('storage/customer/images/'.$contact->picture) }}"
                 class="card-img-top" alt="Wild Landscape"
                 style='height: 500%; width: 100%; object-fit: contain'/>

        </div>
        <!-- /.box-body -->
@include('contacts.partials.asset_status')
    </div>
</div>