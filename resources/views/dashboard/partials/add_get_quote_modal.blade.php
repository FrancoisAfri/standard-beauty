<div id="send-quote-modal" class="modal modal-default fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="send-quote-form">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Fill In The Form</h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-2 control-label">Firstname</label>
                        <div class="col-sm-10">
							<input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter Firstname" required>
						</div>
                    </div>
					<div class="form-group">
                        <label for="surname" class="col-sm-2 control-label">Surname</label>
                        <div class="col-sm-10">
							<input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Enter Surname" required>
						</div>
                    </div>
					<div class="form-group">
                        <label for="company_email" class="col-sm-2 control-label">Company Email</label>
                        <div class="col-sm-10">
							<input type="text" class="form-control" id="company_email" name="company_email" value="{{ old('company_email') }}" placeholder="Enter Company Email" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="contact_number" class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
							<input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="Enter Contact Number" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="portal_option" class="col-sm-2 control-label">Portal Option</label>
                        <div class="col-sm-10">
							<select class="form-control select2" style="width: 100%;" id="portal_option" name="portal_option">
								<option selected="selected" value="0">*** Select Portal Option ***</option>
								<option value="Branded">Branded</option>
								<option value="Non branded">Non branded</option>
							</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="users_range" class="col-sm-2 control-label">How many users?</label>
                        <div class="col-sm-10">
							<select class="form-control select2" style="width: 100%;" id="users_range" name="users_range">
								<option selected="selected" value="0">*** Select Users Range ***</option>
								<option value="1 - 100 Users">1 - 100 Users</option>
								<option value="100 - 500 Users">100 - 500 Users</option>
								<option value="500 - 1000 Users">500 - 1000 Users</option>
								<option value="1000 - 1500 Users">1000 - 1500 Users</option>
								<option value="1500 - 2000 Users">1500 - 2000 Users</option>
								<option value="Over 2000 Users">Over 2000 Users</option>
							</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="adv" class="col-sm-2 control-label">Would you be interested in advertising your company on all our portals?</label>
                        <div class="col-sm-10">
							<select class="form-control select2" style="width: 100%;" id="adv" name="adv">
								<option selected="selected" value="0">*** Select Option ***</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
                    <button type="button" id="send_quote" class="btn btn-primary"><i class="fa fa-upload"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>