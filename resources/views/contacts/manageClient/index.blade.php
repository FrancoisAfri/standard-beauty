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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

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

                                <h1>
                                    Customer Details</h1>
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="" data-toggle="tooltip" title="information"><a
                                                    href="#information" data-toggle="tab">Info</a></li>
                                        <li class="" data-toggle="tooltip" title="Transfers"><a href="#transfares"
                                                                                       data-toggle="tab">Skin profile</a>
                                        </li>
										<li class="" data-toggle="tooltip" title="progress"><a href="#progress"
                                                                                       data-toggle="tab">Progress</a>
                                        </li>
                                        <li class=" pull-right">
                                            <button type="button" class="btn btn-default pull-right" id="back_button"><i
                                                        class="fa fa-arrow-left"></i> Back
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="information">
                                            @include('contacts.Tabs.information-tab')
                                        </div>
                                        <div class="tab-pane" id="transfares">
											@include('contacts.Tabs.skin-profile-tab')
                                        </div>
										<div class="tab-pane" id="progress">
											@include('contacts.Tabs.customer-progress-tab')
                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
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
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
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
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script src="{{ asset('custom_components/js/dataTable.js') }}"></script>

    <script>
        $(function () {

            $(".select2").select2();

            $('[data-toggle="tooltip"]').tooltip();

            //back
            $('#back_button').click(function () {
                location.href = '{{route('index')}}';
            });

            $('table.files').DataTable({

                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
            });


            // reposition modal
            $('.modal').on('show.bs.modal', reposition);

            //Initialize iCheck/iRadio Elements
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '10%' // optional
            });

            // Initialize date picker Elements
            $('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true
            }).datepicker("setDate", 'now');

            // auto hide field elements
            hideFields();
            $('#rdo_store, #rdo_user').on('ifChecked', function () {
                hideFields();
            });

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
