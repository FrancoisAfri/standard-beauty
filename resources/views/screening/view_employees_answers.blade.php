@extends('layouts.main_layout')
@section('page_dependencies')
	<!-- iCheck -->
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/green.css">
@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-10 col-md-offset-1">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title"><b>{{$levelsFour->name}}: </b> {{ !empty($answer->site->name) ? $answer->site->name : '' }}</br>
											<b>Employee : </b> {{ !empty($answer->employee->first_name) && !empty($answer->employee->surname) ? $answer->employee->first_name.' '.$answer->employee->surname : '' }}</br>
											<b>Screening Date : </b> {{ !empty($answer->date_captured) ? date('d M Y', $answer->date_captured) : '' }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
				<form class="form-horizontal" method="POST">
					<div class="box-body">
						<div class="form-group">
							<label for="question_1" class="col-sm-3 control-label">Does anyone in your household work in a facility where COVID-19 patients are being treated?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="question_1" id="question_1" value="{{ !empty($answer->question_1) && $answer->question_1 == 1 ? 'Yes' : 'No' }}" disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="question_2" class="col-sm-3 control-label">In the past 14 days have you come into contact with a COVID-19 positive or suspected positive person?</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="question_2" id="question_2" value="{{ !empty($answer->question_2) && $answer->question_2 == 1 ? 'Yes' : 'No' }}" disabled>
								</div>
						</div>
						<div class="form-group">
							<label for="question_3" class="col-sm-3 control-label">In the past 14 days, have you travelled or been in contact with someone who has travelled to an area with local transmission of COVID-19?</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="question_3" id="question_3" value="{{ !empty($answer->question_3) && $answer->question_3 == 1 ? 'Yes' : 'No' }}" disabled>
								</div>
						</div>
						<div class="form-group">
						<label for="question_4" class="col-sm-3 control-label">Has you or anyone in your household been tested for COVID-19 in the past 3 days?</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="question_4" id="question_4" value="{{ !empty($answer->question_4) && $answer->question_4 == 1 ? 'Yes' : 'No' }}" disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="question_5" class="col-sm-3 control-label">Do you have any illness in the past 14 days?</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="question_5" id="question_5" value="{{ !empty($answer->question_5) && $answer->question_5 == 1 ? 'Yes' : 'No' }}" disabled>
								</div>
						</div>
						<div class="form-group">
							<label for="question_6" class="col-sm-3 control-label">Did you have any of these in the last 14 days:
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
									<input type="text" class="form-control" name="question_6" id="question_6" value="{{ !empty($answer->question_6) && $answer->question_6 == 1 ? 'Yes' : 'No' }}" disabled>
								</div>
						</div>
						<div class="form-group">
							<label for="question_7" class="col-sm-3 control-label">Have you lost your sense of smell and or appetite</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="question_7" id="question_7" value="{{ !empty($answer->question_7) && $answer->question_7 == 1 ? 'Yes' : 'No' }}" disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="question_8" class="col-sm-3 control-label">Have you attended any mass gathering in the past 14 days, eg funeral?</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="question_8" id="question_8" value="{{ !empty($answer->question_8) && $answer->question_8 == 1 ? 'Yes' : 'No' }}" disabled>
								</div>
						</div>
					</div>
				</form>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="button" id="cancel" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> Back</button>
				</div>
            </div>
            <!-- /.box -->
        </div>
		@if(Session('success_add'))
			@include('contacts.partials.success_action', ['modal_title' => "Record Added!", 'modal_content' => session('success_add')])
		@endif
    </div>
@endsection

@section('page_script')
   <script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- iCheck -->
    <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    <!-- Start Bootstrap File input -->
    <!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files. This must be loaded before fileinput.min.js -->
    <script src="/bower_components/bootstrap_fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="/bower_components/bootstrap_fileinput/js/fileinput.min.js"></script>
    <!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
    <script src="/bower_components/bootstrap_fileinput/themes/fa/theme.js"></script>
    <!-- optionally if you need translation for your language then include locale file as mentioned below
    <script src="/bower_components/bootstrap_fileinput/js/locales/<lang>.js"></script>-->
    <!-- End Bootstrap File input -->

    <!-- Ajax form submit -->
    <script src="/custom_components/js/modal_ajax_submit.js"></script>

    <!-- Ajax dropdown options load -->
    <script src="/custom_components/js/load_dropdown_options.js"></script>

    <script>
        $(function () {
			//Cancel button click event
            document.getElementById("cancel").onclick = function () {
               location.href = "/";
            };
           //Initialize iCheck/iRadio Elements
            $('.rdo-iCheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
				increaseArea: '20%' // optional
			});
            //Phone mask
            $("[data-mask]").inputmask();

            // [bootstrap file input] initialize with defaults
            $("#input-1").fileinput();
            // with plugin options
            //$("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});

            //Tooltip
            $('[data-toggle="tooltip"]').tooltip();

            //Vertically center modals on page
            function reposition() {
                var modal = $(this),
                        dialog = modal.find('.modal-dialog');
                modal.css('display', 'block');

                // Dividing by two centers the modal exactly, but dividing by three
                // or four works better for larger screens.
                dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
            }
            // Reposition when a modal is shown
            $('.modal').on('show.bs.modal', reposition);
            // Reposition when the window is resized
            $(window).on('resize', function() {
                $('.modal:visible').each(reposition);
            });

            //Show success action modal
            $('#success-action-modal').modal('show');
        });
    </script>
@endsection