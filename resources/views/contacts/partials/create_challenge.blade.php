<div id="add-challenge-modal" class="modal modal-default fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-challenge-form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Challenge</h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"> Title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title" value=""
                                   placeholder="Enter Title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instructions" class="col-sm-2 control-label">Instructions</label>
                        <div class="col-sm-8">
							<textarea class="form-control" id="instructions" name="instructions" placeholder="Enter Instructions"required></textarea>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="youtube_link" class="col-sm-2 control-label"> Youtube Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="youtube_link" name="youtube_link" value=""
                                   placeholder="Enter Link" required>
                        </div>
                    </div>
					 <div class="form-group">
                        <label for="picture" class="col-sm-2 control-label"> Picture</label>
                        <div class="col-sm-8">
                            <input type="file" id="picture" name="picture" class="file file-loading"
                                   data-allowed-file-extensions='["jpg", "jpeg", "png"]' data-show-upload="false" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_from" class="col-sm-2 control-label">Date From</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="date_from" name="date_from" value=""
                                   placeholder="Enter Date From" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_to" class="col-sm-2 control-label">Date To</label>
                        <div class="col-sm-8">
							<input type="tel" class="form-control" id="date_to" name="date_to" 
							value="{{ old('cell_number') }}" placeholder="Enter Date To" data-mask required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="add-challenge" class="btn btn-warning"><i
                                class="fa fa-cloud-upload"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


