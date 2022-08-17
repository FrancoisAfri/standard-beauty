@extends('layouts.main_layout')

@section('page_dependencies')
    <!-- Include Date Range Picker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/blue.css">
    <!-- bootstrap file input -->
    <link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"/>
    <!--Time Charger-->


@endsection
@section('content')
    <div class="row">
        <!-- New User Form -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-search"></i>
                    <h3 class="box-title">Seach Content</h3>
                </div>

                <form name="leave-application-form" class="form-horizontal" method="POST" action="/cms/search/CamponyNews"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="box-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button>
                                <h4><i class="icon fa fa-ban"></i> Invalid Input Data!</h4>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group {{ $errors->has('leave_types_id') ? ' has-error' : '' }}">
                            <label for="days" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control pull-left" id="name" name="name" value=""/>
                            </div>
                        </div>
						<div class="form-group">
							<label for="due_date" class="col-sm-2 control-label"> Expiring Date</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input type="text" class="form-control daterangepicker" id="day" name="day" value="" placeholder="Select Expiring Date...">
								</div>
							</div>
						</div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" id="load-allocation" name="load-allocation"
                                   class="btn btn-primary pull-right" value="Submit">
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('page_script')
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- Bootstrap date picker -->
    <script src="/bower_components/AdminLTE/plugins/daterangepicker/moment.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
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
    <!-- optionally if you need translation for your language then include locale file as mentioned below -->
    <!--<script src="/bower_components/bootstrap_fileinput/js/locales/<lang>.js"></script>-->
    <!-- iCheck -->
    <script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>

    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Phone mask
            $("[data-mask]").inputmask();


            //Initialise date range picker elements
            $('.daterangepicker').daterangepicker({
                format: 'dd/mm/yyyy',
                endDate: '-1d',
                autoclose: true
            });

            //Initialize iCheck/iRadio Elements
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
 
        });
    </script>
@endsection