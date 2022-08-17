<div id="add-news-modal" class="modal modal-default fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-news-form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Content </h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label"> Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value=""
                                   placeholder="Enter Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="link" class="col-sm-2 control-label"> Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="link" name="link" value=""
                                   placeholder="Enter Link" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="adv_number" class="col-sm-2 control-label"> Position</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="adv_number" name="adv_number" value=""
                                   placeholder="Enter Position" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exp_date" class="col-sm-2 control-label"> Expiring Date </label>

                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" id="exp_date" name="exp_date"
                                       value="{{ old('exp_date') }}" placeholder="Click to Select a Date...">
                            </div>
                        </div>
                    </div>
                    <div class="form-group zip-field">
                        <label for="image" class="col-sm-2 control-label">Upload a Picture</label>

                        <div class="col-sm-8">

                            <input type="file" id="image" name="image" class="file file-loading"
                                   data-allowed-file-extensions='["jpg", "jpeg", "png"]' data-show-upload="false">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="add_news" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
           