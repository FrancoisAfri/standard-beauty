<div id="add-affirmation-modal" class="modal modal-default fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-affirmation-form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Affirmation</h4>
                </div>
                <div class="modal-body">
                    <div id="invalid-input-alert"></div>
                    <div id="success-alert"></div>
                    <div class="form-group">
                        <label for="affirmation" class="col-sm-2 control-label"> Affirmation</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="affirmation" name="affirmation" value=""
                                   placeholder="Enter Affirmation" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" id="add-affirmation" class="btn btn-warning"><i
                                class="fa fa-cloud-upload"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


