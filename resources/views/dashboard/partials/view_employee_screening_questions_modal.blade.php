<div id="view-employee-screening-questions-modal" class="modal modal-default fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" name="add-kpa-form">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">View Answers</h4>
                </div>
                <div class="modal-body">
                    <div id="kpa-invalid-input-alert"></div>
                    <div id="kpa-success-alert"></div>
                    <div class="form-group">
					<label for="answer_1" class="col-sm-3 control-label">Does anyone in your household work in a facility where COVID-19 patients are being treated?</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="answer_1" id="answer_1" value="" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="answer_2" class="col-sm-3 control-label">In the past 14 days have you come into contact with a COVID-19 positive or suspected positive person?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="answer_2" id="answer_2" value="" disabled>
							</div>
					</div>
					<div class="form-group">
						<label for="answer_3" class="col-sm-3 control-label">In the past 14 days, have you travelled or been in contact with someone who has travelled to an area with local transmission of COVID-19?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="answer_3" id="answer_3" value="" disabled>
							</div>
					</div>
					<div class="form-group">
					<label for="answer_4" class="col-sm-3 control-label">Has you or anyone in your household been tested for COVID-19 in the past 3 days?</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="answer_4" id="answer_4" value="" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="answer_5" class="col-sm-3 control-label">Do you have any illness in the past 14 days?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="answer_5" id="answer_5" value="" disabled>
							</div>
					</div>
					<div class="form-group">
						<label for="answer_6" class="col-sm-3 control-label">Did you have any of these in the last 14 days:
								*	Cough
								*	Sore throat
								*	Fever
								*	Chills
								*	Headache
								*	Shortness of breath
								*	Muscle or joint pain
								*	Sinusitis
								*	Diarrhoea
								</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="answer_6" id="answer_6" value="" disabled>
							</div>
					</div>
					<div class="form-group">
						<label for="answer_7" class="col-sm-3 control-label">Have you lost your sense of smell and or appetite</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="answer_7" id="answer_7" value="" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="answer_8" class="col-sm-3 control-label">Have you attended any mass gathering in the past 14 days, eg funeral?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="answer_8" id="answer_8" value="" disabled>
							</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>