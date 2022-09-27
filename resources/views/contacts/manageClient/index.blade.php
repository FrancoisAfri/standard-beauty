@extends('layouts.main_layout')
@section('page_dependencies')

    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap_fileinput/css/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/plugins/iCheck/square/green.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fine-uploader/fine-uploader-gallery.css') }}">
    <script src="/custom_components/js/deleteAlert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <!-- bootstrap file input -->
@stop
@section('content')
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class=" tab-content">
                <div class="activetab-pane" id="info">
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
									<div>
										@include('contacts.Tabs.information-tab')
									</div>
                                        <!-- /.tab-pane -->
                                </div>
                                <!-- /.nav-tabs-custom -->
								<li class=" pull-left">
                            </div>
                            <!-- /.col -->
																<button type="button" class="btn btn-default pull-left" id="back_button"><i
										class="fa fa-arrow-left"></i> Back
									</button>
								</li>

                        </div>
                        <!-- /.row -->
                    </section>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.col -->
        <!-- /.row -->
    </section>
@stop
@section('page_script')
	<script src="{{ asset('custom_components/js/modal_ajax_submit.js') }}"></script>
    <script src="{{ asset('custom_components/js/deleteAlert.js') }}"></script>
    <!-- the main fileinput plugin file -->
    <script src="{{ asset('bower_components/bootstrap_fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/fine-uploader/fine-uploader.js') }}"></script>
    <script src="/custom_components/js/deleteAlert.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
            $('[data-toggle="tooltip"]').tooltip();
            //back
            $('#back_button').click(function () {
                location.href = '{{route('index')}}';
            });
            // reposition modal
            //$('.modal').on('show.bs.modal', reposition);
            $('.delete_confirm').click(function (event) {
                let form = $(this).closest("form");
                let name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                            swal("Poof! Your Record has been deleted!", {
                                icon: "success",
                            });
                        }
                    });
            });
            <!-- change status -->
            let statusId;
            $('#change-asset_status-modal').on('show.bs.modal', function (e) {
                let btnEdit = $(e.relatedTarget);
                statusId = btnEdit.data('id');
                let asset_status = btnEdit.data('asset_status');
                let modal = $(this);
                modal.find('#asset_status').val(asset_status);
            });
            $('#change-status').on('click', function () {
                let strUrl = '/customer/act/' + statusId;
                let modalID = 'change-asset_status-modal';
                let objData = {
                    asset_status: $('#' + modalID).find('#asset_status').val(),
                    _token: $('#' + modalID).find('input[name=_token]').val()
                };
                let submitBtnID = 'change-status';
                let redirectUrl = '{{ route('customer.show', $contact->id) }}';
                let successMsgTitle = 'Changes Saved!';
                let successMsg = 'Status has been successfully changed.';
                let Method = 'PATCH';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, Method);
            });
        });
    </script>
@stop
