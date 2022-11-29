@extends('layouts.main_layout')
@section('page_dependencies')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/blue.css">
    <!-- bootstrap file input -->
    <link href="/bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"/>
    <!--Time Charger-->
@endsection
@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <i class="fa fa-sliders pull-right"></i>
                    <h3 class="box-title">Setup</h3>
                </div>
                <form class="form-horizontal" method="POST"
                      action="/routine/save_setup/{{ (!empty($setup->id)) ?  $setup->id : ''}}" enctype="multipart/form-data">
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
                        <div class="box-body" style="max-height: 1000px; overflow-y: scroll;">
                            <table class="table table-striped table-bordered">
								<tr>
                                    <td class="caption" colspan="2">Upload Directory</td>

                                    <td colspan="6"><input type="text" name="document_root" class="form-control"
                                                           value="{{ !empty($setup->document_root) ? $setup->document_root : '' }}" 
                                                           placeholder="Upload Directory">
                                </tr>
                            </table>
                        </div>
                        <br>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-cog"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
   
    <script type="text/javascript">
	//Cancel button click event

    </script>
@endsection
