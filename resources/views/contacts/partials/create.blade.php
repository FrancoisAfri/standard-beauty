<div id="add-client-modal" class="modal modal-default fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-client-form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Customer</h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label"> Firstname</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="firstname" name="firstname" value=""
                                   placeholder="Enter Firstname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="surname" class="col-sm-2 control-label"> Surname</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="surname" name="surname" value=""
                                   placeholder="Enter Surname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label"> Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" value=""
                                   placeholder="Enter Email" required >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cell_number" class="col-sm-2 control-label"> Phone Number</label>
                        <div class="col-sm-8">
							<input type="tel" class="form-control" id="cell_number" name="cell_number" 
							value="{{ old('cell_number') }}" data-inputmask='"mask": "(999) 999-9999"' 
							placeholder="Enter Phone Number" data-mask required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"> Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address" name="address" value=""
                                   placeholder="Enter Address" required>
                        </div>
                    </div>
                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="picture" class="col-sm-2 control-label">Picture</label>
                        <div class="col-sm-8">
                            <input type="file" id="picture" name="picture" class="file file-loading"
                                   data-allowed-file-extensions='["jpg", "jpeg", "png"]' data-show-upload="false">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="add-client" class="btn btn-warning"><i
                                class="fa fa-cloud-upload"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


