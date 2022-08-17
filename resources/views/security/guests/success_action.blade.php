<div id="success-action-modal" class="modal modal-success fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-check"></i> {{ $modal_title }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ $modal_content }}</p>
            </div>
            <div class="modal-footer">
				<a href="/login" style="color:white"><h4>Go To Login Page</h4></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>