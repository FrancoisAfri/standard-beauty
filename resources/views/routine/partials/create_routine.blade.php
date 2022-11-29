<div id="add-routine-modal" class="modal modal-default fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-routine-form" enctype="multipart/form-data">
				<input type="hidden" name="file_index" id="file_index" value="1"/>
				<input type="hidden" name="total_files" id="total_files" value="1"/>
			   {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Routine</h4>
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
                        <label for="content" class="col-sm-2 control-label"> Content</label>
                        <div class="col-sm-8">
							<textarea name="content" id="content" class="form-control" rows="4">{{ old('content') }}</textarea>
                        </div>
                    </div>
					<div id="tab_10">
						<hr class="hr-text" data-content="PICTURES UPLOAD">
						<div class="row" id="tab_tab">
							<div class="col-sm-6" id="file_row" style="margin-bottom: 15px; display:none">
								<input type="file" id="picture" disabled="disabled" class="form-control">
							</div>
							<div class="col-sm-6" style="margin-bottom: 15px;">
								<input type="file" id="picture" name="picture[1]"
								class="form-control">
							</div>
							<div class="col-sm-6" style="display:none;" id="name_row">
								<input type="text" class="form-control" id="hyper_link" name="hyper_link"
									   placeholder="Hyperlink" disabled="disabled">
							</div>
							<div class="col-sm-6" id="1" name="1" style="margin-bottom: 15px;">
								<input type="text" class="form-control" id="hyper_link[1]" name="hyper_link[1]"
									   placeholder="Hyperlink">
							</div>
						</div>
						<div class="row" id="final_row">
							<div class="col-sm-12">
								<button type="button" class="btn btn-default btn-block btn-flat add_more" onclick="addFile()">
									<i class="fa fa-clone"></i> Add More
								</button>
							</div>
						</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="add-routine" class="btn btn-warning"><i
                                class="fa fa-cloud-upload"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


