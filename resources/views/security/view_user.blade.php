@extends('layouts.main_layout')
@section('page_dependencies')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
<!-- iCheck -->
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/green.css">
    <!-- bootstrap file input -->
    <link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <!-- User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-user pull-right"></i>
                    <h3 class="box-title">User</h3>
                    <p>User details:</p>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="/users/{{ $user->id }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="box-body" id="view_users">
                        @if (isset($view_by_admin) && $view_by_admin === 1)
                            @foreach($division_levels as $division_level)
                                <div class="form-group manual-field{{ $errors->has('division_level_' . $division_level->level) ? ' has-error' : '' }}">
                                            <label for="{{ 'division_level_' . $division_level->level }}"
                                                   class="col-sm-2 control-label">{{ $division_level->name }}</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-black-tie"></i>
                                                    </div>
                                                    <select id="{{ 'division_level_' . $division_level->level }}"
                                                            name="{{ 'division_level_' . $division_level->level }}"
                                                            class="form-control"
                                                            onchange="divDDOnChange(this, null, 'view_users')">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">First Name </label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->person->first_name }}" placeholder="First Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="surname" class="col-sm-2 control-label">Surname</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="surname" name="surname" value="{{ $user->person->surname }}" placeholder="Surname" required>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                            <label for="id_number" class="col-sm-2 control-label">ID Number</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <input type="number" class="form-control" id="id_number" name="id_number" value="{{ $user->person->id_number }}" placeholder="ID Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="employee_number" class="col-sm-2 control-label">Employee Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <input type="text" class="form-control" id="employee_number" name="employee_number" value="{{ $user->person->employee_number }}" placeholder="Employee Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell_number" class="col-sm-2 control-label">Cell Number</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="cell_number" value="{{ $user->person->cell_number }}" data-inputmask='"mask": "(999) 999-9999"' placeholder="Cell Number" data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->person->email }}" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="date_of_birth" class="col-sm-2 control-label">Date of Birth</label>
                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="date_of_birth" placeholder="  dd/mm/yyyy" value="{{ ($user->person->date_of_birth) ? date('d/m/Y',$user->person->date_of_birth) : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res_address" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="res_address" class="form-control" placeholder="Address">{{ $user->person->res_address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res_suburb" class="col-sm-2 control-label">Suburb</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <input type="text" class="form-control" id="res_suburb" name="res_suburb" value="{{ $user->person->res_suburb }}" placeholder="Suburb">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res_city" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <input type="text" class="form-control" id="res_city" name="res_city" value="{{ $user->person->res_city }}" placeholder="City">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res_postal_code" class="col-sm-2 control-label">Postal Code</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <input type="number" class="form-control" id="res_postal_code" name="res_postal_code" value="{{ $user->person->res_postal_code }}" placeholder="Postal Code">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res_province_id" class="col-sm-2 control-label">Province</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <select name="res_province_id" class="form-control">
                                        <option value="">*** Select Your Province ***</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ ($user->person->res_province_id == $province->id) ? ' selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-venus-mars"></i>
                                    </div>
                                    <select name="gender" class="form-control">
                                        <option value="">*** Select Your gender ***</option>
                                        <option value="1" {{ ($user->person->gender === 1) ? ' selected' : '' }}>Male</option>
                                        <option value="2" {{ ($user->person->gender === 2) ? ' selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marital_status" class="col-sm-2 control-label">Marital Status</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-venus-mars"></i>
                                    </div>
                                    <select name="marital_status" class="form-control">
                                        <option value="">*** Select Your Marital Status ***</option>
                                        @foreach($marital_statuses as $marital_status)
                                            <option value="{{ $marital_status->id }}" {{ ($user->person->marital_status == $marital_status->id) ? ' selected' : '' }}>{{ $marital_status->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ethnicity" class="col-sm-2 control-label">Ethnicity</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-bar-chart"></i>
                                    </div>
                                    <select name="ethnicity" class="form-control">
                                        <option value="">*** Select Your Ethnic Group ***</option>
                                        @foreach($ethnicities as $ethnicity)
                                            <option value="{{ $ethnicity->id }}" {{ ($user->person->ethnicity == $ethnicity->id) ? ' selected' : '' }}>{{ $ethnicity->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="chronic_diseases" class="col-sm-2 control-label">Chronic Diseases</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <textarea name="chronic_diseases" class="form-control" placeholder="Chronic Diseases">{{ $user->person->chronic_diseases }}</textarea>
                                </div>
                            </div>
                        </div>
						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="transportation_method" class="col-sm-2 control-label">Transportation Method</label>
                            <div class="col-sm-10">
                                <label class="radio-inline rdo-iCheck" style="padding-left: 0px;"><input type="radio" id="rdo_public" name="transportation_method" value="1" {{ ($user->person->transportation_method == 1) ? ' checked' : '' }}> Public</label>
                                <label class="radio-inline rdo-iCheck"><input type="radio" id="rdo_private" name="transportation_method" value="2" {{ ($user->person->transportation_method == 2) ? ' checked' : '' }}>  Private</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profile_pic" class="col-sm-2 control-label">Profile Picture</label>

                            <div class="col-sm-10">
                                @if(!empty($avatar))
                                    <div style="margin-bottom: 10px;">
                                        <img src="{{ $avatar }}" class="img-responsive img-thumbnail" width="200" height="200">
                                    </div>
                                @endif
                                <input type="file" id="profile_pic" name="profile_pic" class="file file-loading" data-allowed-file-extensions='["jpg", "jpeg", "png"]' data-show-upload="false">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="training_policy_doc" class="col-sm-2 control-label">Worker Assessment Form Upload</label>

                            <div class="col-sm-10">
							@if(!empty($training_doc))
								<a class="btn btn-default btn-flat btn-block pull-right "
									href="{{Storage::disk('local')->url("training/$training_doc") }}"
									target="_blank"><i class="fa fa-file-pdf-o"></i> View Document</a> 
							@else
								<a class="btn btn-default pull-centre "><i
											class="fa fa-exclamation-triangle"></i> Nothing Uploaded</a>
							@endif
							<input type="file" id="training_policy_doc" name="training_policy_doc" class="file file-loading" data-allowed-file-extensions='["doc", "docx", "pdf"]' data-show-upload="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="change_password" class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-10">
                                <font data-toggle="tooltip" title="Click here to change password."><button type="button" id="change_password" class="btn btn-default btn-flat btn-block" data-toggle="modal" data-target="#myPasswordModal"><i class="fa fa-lock"></i> Change Password</button></font>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <button type="button" id="cancel" class="btn btn-default pull-left">Cancel</button>
                        <button type="submit" name="command" id="update" class="btn btn-primary pull-right">Update</button>
						@if (isset($view_by_admin) && $view_by_admin === 1)
						<button type="button" class="btn btn-primary" id="access_button" onclick="postData({{$user->id}}, 'access');">Modules Access</button>
						@endif
                          
						@if (isset($view_by_admin) && $view_by_admin === 1)
						<button type="button" class="btn btn-warning" id="delete_button" name="command"
								onclick="if(confirm('Are you sure you want to delete this User ?')){ deleteRecord()} else {return false;}"
                                value="Delete"><i class="fa fa-trash"></i> Delete
                        </button>
						@endif
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- End new User Form-->

        <!-- Password Modal form-->
        @if (isset($user_profile) && $user_profile === 1)
            @include('security.partials.change_my_password')
        @elseif (isset($view_by_admin) && $view_by_admin === 1)
            @include('security.partials.change_password')
        @endif
        <!-- /.Password Modal form-->

        <!-- Confirmation Modal -->
        @if(Session('success_edit'))
            @include('contacts.partials.success_action', ['modal_title' => "User's Details Updated!", 'modal_content' => session('success_edit')])
        @endif
    </div>
@endsection

@section('page_script')
    <!-- bootstrap datepicker -->
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
                location.href = "{{ $back }}";
            };

            //Date picker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                endDate: '-1d',
                autoclose: true
            });
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

            //Post password form to server using ajax
            $('#my-password').on('click', function() {
                var strUrl = '{{ '/users/' . $user->id . '/pw' }}';
                var objData = {
                    current_password: $('#current_password').val(),
                    new_password: $('#new_password').val(),
                    confirm_password: $('#confirm_password').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'myPasswordModal';
                var submitBtnID = 'my-password';
                var redirectUrl = null;
                var successMsgTitle = 'Changes Saved!';
                var successMsg = 'The password has been changed successfully.';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            //Post user password form to server using ajax
            $('#user-password').on('click', function() {
                var strUrl = '{{ '/users/' . $user->id . '/upw' }}';
                var objData = {
                    new_password: $('#new_password').val(),
                    _token: $('input[name=_token]').val()
                };
                var modalID = 'myPasswordModal';
                var submitBtnID = 'user-password';
                var redirectUrl = null;
                var successMsgTitle = 'Changes Saved!';
                var successMsg = 'The password has been changed successfully.';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            //Load divisions drop down
            var parentDDID = '';
            var loadAllDivs = 1;
            @if (isset($view_by_admin) && $view_by_admin === 1)
                @foreach($division_levels as $division_level)
                    //Populate drop down on page load
                    var ddID = '{{ 'division_level_' . $division_level->level }}';
                    var postTo = '{!! route('divisionsdropdown') !!}';
                    var selectedOption = '';
                    var divLevel = parseInt('{{ $division_level->level }}');
                    if (divLevel == 5) selectedOption = '{{ $user->person->division_level_5 }}';
                    else if(divLevel == 4) selectedOption = '{{ $user->person->division_level_4 }}';
                    else if(divLevel == 3) selectedOption = '{{ $user->person->division_level_3 }}';
                    else if(divLevel == 2) selectedOption = '{{ $user->person->division_level_2 }}';
                    else if(divLevel == 1) selectedOption = '{{ $user->person->division_level_1 }}';
                    var incInactive = -1;
                    var loadAll = loadAllDivs;
                    loadDivDDOptions(ddID, selectedOption, parentDDID, incInactive, loadAll, postTo);
                    parentDDID = ddID;
                    loadAllDivs = 1;
                @endforeach
            @endif
        });

        //Load divisions drop down

		function postData(id, data)
		{
			if (data == 'access')
				location.href = "/users/module_access/" + id;
			else if (data == 'roles')
				location.href = "/hr/role_users/" + id;
		}
		function deleteRecord() {
			location.href = "/user/delete/{{ $user->id }}";
		}
    </script>
@endsection