@extends('layouts.main_layout')
@section('page_dependencies')

    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	    <!-- bootstrap datepicker -->
    <!-- Include Date Range Picker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/datepicker/datepicker3.css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-barcode pull-right"></i>
                    <h3 class="box-title"> Manage Blog </h3>
                </div>
                <div class="box-body">
                    <div class="box-header">
                        <br>
                        <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                data-target="#add-news-modal">Add Content
                        </button>
                    </div>
                    <div style="overflow-X:auto;">
                        <table id=" " class="blog table table-bordered data-table my-2">
							<thead>
								<tr>
									<th style="width: 10px; text-align: center;"></th>
									<th style="width: 20px; text-align: center;"></th>
									<th>Expiring Date</th>
									<th>name</th>
									<th>Link</th>
									<th style="width: 5px; text-align: center;"></th>
									<th style="width: 5px; text-align: center;"></th>
								</tr>
							</thead>
							<tbody>
								@if (count($Cmsnews) > 0)
									@foreach ($Cmsnews as $news)
										<tr>
											<td>
												<a href="{{ '/cms/viewnews/' . $news->id }}" id="edit_compan"
												   class="btn btn-primary  btn-xs" data-id="{{ $news->id }}"><i
															class="fa fa-pencil-square-o"></i> Edit</a>
											</td>
											<td nowrap>
												<a href="{{ '/view/' . $news->id }}" id="edit_compan"
												   class="btn btn-warning  btn-xs" target="_blank"><i class=""></i> View Content
												</a>
											</td>
											<td>{{!empty($news->expirydate) ? date(' d M Y', $news->expirydate) : ''}}</td>
											<td>{{ !empty($news->name) ? $news->name : ''}}</td>
											<td>{{ !empty($news->link) ? $news->link : ''}}</td>									
											<td>
												<button vehice="button" id="view_ribbons"
														class="btn {{ (!empty($news->status) && $news->status == 1) ? " btn-danger " : "btn-success " }}
																btn-xs" onclick="postData({{$news->id}}, 'actdeac');"><i
															class="fa {{ (!empty($news->status) && $news->status == 1) ?
											  " fa-times " : "fa-check " }}"></i> {{(!empty($news->status) && $news->status == 1) ? "De-Activate" : "Activate"}}
												</button>
											</td>
											<td>
												<form action="/cms/news/delete/{{$news->id}}"
													  method="POST"
													  style="display: inline-block;">
													  {{ csrf_field() }}
													<button type="submit"
															class="btn btn-xs btn-danger btn-flat delete_confirm"
															data-toggle="tooltip" title='Delete'>
														<i class="fa fa-trash"> Delete </i>
													</button>
												</form>
											</td>
										</tr>
									@endforeach
								@endif
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                        <div class="box-footer">
                             <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                data-target="#add-news-modal">Add Content
                        </button>
                        </div>
                    </div>
                </div>
                @include('cms.partials.add_news_modal')
				<!-- Include delete warning Modal form-->
				@if (count($Cmsnews) > 0)
					@include('cms.partials.news_warning_action', ['modal_title' => 'Delete Record', 'modal_content' => 'Are you sure you want to delete this Record? This action cannot be undone.'])
				@endif
        </div>
            </div>
        </div>
    </div>
@stop
@section('page_script')
    <!-- DataTables -->
    {{--    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js"') }}"></script>--}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('custom_components/js/modal_ajax_submit.js') }}"></script>
    <script src="{{ asset('custom_components/js/deleteAlert.js') }}"></script>

    <script src="{{ asset('bower_components/bootstrap_fileinput/js/fileinput.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
	<script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
            
{{--    <script src="{{ asset('custom_components/js/dataTable.js') }}"></script>--}}

    <!-- End Bootstrap File input -->
    <script type="text/javascript">


        function postData(id, data) {
            if (data === 'actdeac') location.href = "/cms/cmsnews_act" + "/" + id;
        }

        $('.popup-thumbnail').click(function(){
            $('.modal-body').empty();
            $($(this).parents('div').html()).appendTo('.modal-body');
            $('#modal').modal({show:true});
        });


        //TODO WILL CREATE A SIGLE GLOBAL FILE
        $('.delete_confirm').click(function (event) {

            var form = $(this).closest("form");

            var name = $(this).data("name");

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

        $(function () {

            $('table.blog').DataTable({

                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            //Show success action modal
			$('#success-action-modal').modal('show');

			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true,
				todayHighlight: true
			});

			//Show success action modal
			@if(Session('changes_saved'))
			$('#success-action-modal').modal('show');
			@endif

			//Post perk form to server using ajax (add)
			$('#add_news').on('click', function () {
				var strUrl = '/cms/crm_news';
				var formName = 'add-news-form';
				var modalID = 'add-news-modal';
				var submitBtnID = 'add_news';
				var redirectUrl = '/cms/viewnews';
				var successMsgTitle = 'New Record Details Added!';
				var successMsg = 'New Content has been Added successfully.';
				modalFormDataSubmit(strUrl, formName, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
			});

        });
    </script>
@stop