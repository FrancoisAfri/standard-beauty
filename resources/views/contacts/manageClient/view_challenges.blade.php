@extends('layouts.main_layout')
@section('page_dependencies')

    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	    <!-- bootstrap datepicker -->
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
                    <h3 class="box-title">Manage Challenges </h3>
                </div>
                <div class="box-body">
                   <!--  <div class="box-header">

                        <div class="form-group container-sm">
                            <form class="form-horizontal" method="get" action="{{ route('index') }}">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <label>Status</label>
                                            <select class="form-control select2 " style="width: 100%;"
                                                   id="status_id" name="status_id" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-left">Submit</button><br>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <br>
                        <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                data-target="#add-challenge-modal">Add Challenge
                        </button>
                    </div> -->
                    <div style="overflow-X:auto;">
                        <table id=" " class="challenge table table-bordered data-table my-2">
                            <thead>
                            <tr>
                                <th style="width: 10px; text-align: center;"></th>
                                <th>Title</th>
                                <th>Instructions</th>
                                <th>Youtube Link</th>
                                <th>Picture</th>
                                <th style="width: 5px; text-align: center;">Date From</th>
                                <th style="width: 5px; text-align: center;">Date To</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </thead>
                            <tbody>
								@if (!empty($challenges))
										@foreach ($challenges as $key => $challenge)
											<tr id="categories-list">
												<td nowrap>
													<button vehice="button" id="edit_licence"
															class="btn btn-warning  btn-xs"
															data-toggle="modal" data-target="#edit-challenge-modal"
															data-id="{{ $challenge->id }}"
															data-title="{{ $challenge->title }}"
															data-instructions="{{$challenge->instructions}}"
															data-youtube_link="{{$challenge->youtube_link}}"
															data-date_from="{{ date(' d M Y', $challenge->date_from)}}"
															data-date_to="{{ date(' d M Y', $challenge->date_to)}}"
															<i class="fa fa-pencil-square-o"></i> Edit
													</button>
												</td>
												<td>
													<a data-toggle="tooltip" title="Click to View Challenge"
													   href="{{ route('challenge.show', $challenge->id)}}">
														{{ (!empty( $challenge->title)) ?  $challenge->title : ''}}
													</a>
												</td>
												<td>{{ (!empty( $challenge->instructions)) ?  $challenge->instructions : ''}}</td>
												<td>{{ (!empty( $challenge->youtube_link)) ?  $challenge->youtube_link : ''}}</td>
												<td>@if(!empty($challenge->picture))
														<div class="popup-thumbnail img-responsive">
															<img src="{{ asset('storage/customer/challenge/'.$challenge->picture) }} "
																 height="70px" width="80px" alt="Challenge image">
														</div>
													@else
														<a class="btn btn-default pull-centre btn-xs"><i class="fa fa-exclamation-triangle"></i> Nothing Uploaded</a>
													@endif</td>
												<td>{{ (!empty( $challenge->date_from)) ?  date(' d M Y', $challenge->date_from) : ''}} </td>
												<td>{{ (!empty( $challenge->date_to)) ?  date(' d M Y', $challenge->date_to) : ''}} </td>
												<td style="text-align: center;">
													<span class="label label-info">{{ (!empty( $challenge->status) && $challenge->status == 1 ) ?  'Active' : 'Inactive'}}</span>
												</td>
												<td>
												</td>
											</tr>
									@endforeach
								@endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="width: 10px; text-align: center;"></th>
                                <th>Title</th>
                                <th>Instructions</th>
								<th>Youtube Link</th>
                                <th>Picture</th>
                                <th style="width: 5px; text-align: center;">Date From</th>
                                <th style="width: 5px; text-align: center;">Date To</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                    data-target="#add-challenge-modal">Add Challenge
                            </button>
                        </div>
                    </div>
                </div>
                @include('contacts.partials.create_challenge')
                @include('contacts.partials.edit_challenge')
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
	<script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- End Bootstrap File input -->
    <script type="text/javascript">

		//Phone mask
        $("[data-mask]").inputmask();
        function postData(id, data) {
           // if (data === 'actdeac') location.href = "{{route('customer.activate_challenge', 'challenges')}}" ;
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

            $('table.challenge').DataTable({

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
			// inialise dates
			$(document).ready(function () {

				$('input[name="date_from"]').datepicker({
					format: 'dd/mm/yyyy',
					autoclose: true,
					todayHighlight: true
				});
			});
			$(document).ready(function () {

				$('input[name="date_to"]').datepicker({
					format: 'dd/mm/yyyy',
					autoclose: true,
					todayHighlight: true
				});
			});
			$(document).ready(function () {

				$('input[name="date_from_update"]').datepicker({
					format: 'dd/mm/yyyy',
					autoclose: true,
					todayHighlight: true
				});
			});
			$(document).ready(function () {

				$('input[name="date_to_update"]').datepicker({
					format: 'dd/mm/yyyy',
					autoclose: true,
					todayHighlight: true
				});
			});
            //$('.modal').on('show.bs.modal', reposition);

            $('#add-challenge').on('click', function () {
                let strUrl = '{{route('store.challenge')}}';
                let modalID = 'add-challenge-modal';
                let formName = 'add-challenge-form';

                //console.log(formName)
                let submitBtnID = 'add-challenge';
                let redirectUrl = '{{ route('customer.challenges') }}';
                let successMsgTitle = 'Challenge Added!';
                let successMsg = 'Record has been updated successfully.';
                modalFormDataSubmit(strUrl, formName, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            let challengeId;
            $('#edit-challenge-modal').on('shown.bs.modal', function (e) {
                let btnEdit = $(e.relatedTarget);
                challengeId = btnEdit.data('id');
                let title = btnEdit.data('title');
                let instructions = btnEdit.data('instructions');
                let youtube_link = btnEdit.data('youtube_link');
                let date_from = btnEdit.data('date_from');
                let date_to = btnEdit.data('date_to');
                let modal = $(this);
                modal.find('#title').val(title);
                modal.find('#instructions').val(instructions);
                modal.find('#youtube_link').val(youtube_link);
                modal.find('#date_from_update').val(date_from);
                modal.find('#date_to_update').val(date_to);
            });

            // update modal
            $('#edit-challenge').on('click', function () {

                let strUrl = '/customer/challenge/update/' + challengeId;
                let modalID = 'edit-challenge-modal';
                let objData = {
                    title: $('#'+modalID).find('#title').val(),
                    instructions: $('#'+modalID).find('#instructions').val(),
                    date_from_update: $('#'+modalID).find('#date_from_update').val(),
                    date_to_update: $('#'+modalID).find('#date_to_update').val(),
                    youtube_link: $('#'+modalID).find('#youtube_link').val(),
                    _token: $('#'+modalID).find('input[name=_token]').val()
                };

                let submitBtnID = 'edit-challenge';
                let redirectUrl = '{{ route('customer.challenges') }}';
                let successMsgTitle = 'Changes Saved!';
                let successMsg = 'Record has been updated successfully.';
                let Method = 'PATCH';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, Method);
            });

        });
    </script>
@stop