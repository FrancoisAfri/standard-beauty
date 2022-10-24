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
            <div class="col-md-12">
                <h1>
				{{$challenge->title}}
                </h1>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="" data-toggle="tooltip" title="users"><a
                                    href="#users" data-toggle="tab">Users</a>
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
                        <div class="active tab-pane" id="users">
                            @include('contacts.Tabs.challenge-users-tab')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="progress">
                            @include('contacts.Tabs.challenge-progress-tab')
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

@stop
@section('page_script')
   <!-- Task timer --> 
    <script>
        $(function () {
            //back
            $('#back_button').click(function () {
                location.href = '{{route('customer.challenges')}}';
            });

            /*$('table.progress').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
            }); 
			$('table.users').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
            });*/
        });
    </script>
@stop
