<div id="add-employee-comment-modal" class="modal modal-default fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-comment-form">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Comment</h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10">
						<textarea rows="4" cols="50" class="form-control" id="comment" name="comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
                    <button type="button" id="save-comment" class="btn btn-primary"><i class="fa fa-upload"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>