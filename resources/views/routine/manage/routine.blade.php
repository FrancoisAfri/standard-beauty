@extends('layouts.main_layout')
@section('page_dependencies')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap_fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-barcode pull-right"></i>
                    <h3 class="box-title">Manage Routines ({{$goal->title}}) </h3>
                </div>
                <div class="box-body">
                    <div class="box-header">
                        <div class="form-group container-sm">
                            <form class="form-horizontal" method="get" action="{{ route('routine.show',$goal->id) }}">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <label>Status</label>
                                            <select class="form-control select2 " style="width: 100%;"
                                                   id="status_id" name="status_id" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                    <option value="1"{{ ($status == 1) ?' selected' : '' }}>Active</option>
                                                    <option value="2"{{ ($status == 2) ?' selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-sm-8">
                                            <label>Goals</label>
                                            <select class="form-control select2 " style="width: 100%;"
                                                   id="goal_id" name="goal_id" data-select2-id="1" tabindex="-1" aria-hidden="true">
												   <option value="">*** Select a Goal ***</option>
                                            @foreach($goals as $goali)
                                                <option value="{{ $goali->id }}" {{ ($goal_id == $goali->id) ? ' selected' : '' }}>{{ $goali->title }}</option>
                                            @endforeach
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
                                data-target="#add-routine-modal">Add Routine
                        </button>
                    </div>
                    <div style="overflow-X:auto;">
                        <table id=" " class="routine table table-bordered data-table my-2">
                            <thead>
                            <tr>
                                <th style="width: 10px; text-align: center;"></th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Pictures</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($routines) > 0)
                                <ul class="products-list product-list-in-box">
                                    @foreach ($routines as $key => $routine)
                                        <tr id="routines-list">
                                            <td nowrap>
                                                <button type="button" id="edit_routine"
                                                        class="btn btn-warning  btn-xs"
                                                        data-toggle="modal" data-target="#edit-routine-modal"
                                                        data-id="{{ $routine->id }}"
                                                        data-title="{{ $routine->title }}"
                                                        data-content="{{$routine->content}}"
														<i class="fa fa-pencil-square-o"></i> Edit
                                                </button>
                                            </td>
                                            <td>
												{{ (!empty( $routine->title)) ?  $routine->title : ''}}
                                            </td>
                                            <td>
                                                {{ (!empty( $routine->content)) ?  $routine->content : ''}}
                                            </td>
											<td>
												@if(!empty($routine->routineLink))
													@foreach ($routine->routineLink as $link)
													<a href="{{$link->hyper_link}}" target="_blank"><img src="{{ asset('storage/routine-pics/'.$link->picture) }} "
                                                         height="70px" width="80px" alt="Link image"></a>
													
													@endforeach
												@else
													<a class="btn btn-default pull-centre btn-xs"><i class="fa fa-exclamation-triangle"></i> Nothing Uploaded</a>
												@endif
                                            </td>
											<td style="text-align: center;">
												<button type="button" id="view_ribbons" class="btn {{ (!empty($routine->status) && $routine->status == 1) ? " btn-danger " : "btn-success " }}
											btn-xs" onclick="postData({{$routine->id}}, 'actdeac');"><i class="fa {{ (!empty($routine->status) && $routine->status == 1) ?
											"fa-times " : "fa-check " }}"></i> {{(!empty($routine->status) && $routine->status == 1) ? "De-Activate" : "Activate"}}</button>
                                            </td>
                                            <td>
                                                <form action="{{ route('routine.destroy', $routine->id) }}"
                                                      method="POST"
                                                      style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                            <tfoot>
                            <tr>
                                <th style="width: 10px; text-align: center;"></th>
                                <th>Title</th>
                                <th>Content</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                    data-target="#add-routine-modal">Add Routine
                            </button>
                        </div>
                    </div>
                </div>
                @include('routine.partials.create_routine')
                @include('routine.partials.edit_routine')
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
{{--    <script src="{{ asset('custom_components/js/dataTable.js') }}"></script>--}}
	<script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- End Bootstrap File input -->
    <script type="text/javascript">

		//Phone mask
        $("[data-mask]").inputmask();
        function postData(id, data) {
            if (data === 'actdeac') location.href = "{{route('routine.activate', '')}}" + "/" + id;
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
            $('table.routine').DataTable({
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

            //$('.modal').on('show.bs.modal', reposition);

            $('#add-routine').on('click', function () {
				let strUrl = '/routine/save/{{$goal->id}}';
                let modalID = 'add-routine-modal';
                let formName = 'add-routine-form';

                let submitBtnID = 'add-routine';
                let redirectUrl = '/routine/show/{{$goal->id}}';
                let successMsgTitle = 'Routine Added!';
                let successMsg = 'Record has been added successfully.';
                modalFormDataSubmit(strUrl, formName, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });

            // show modal info
            let routineId;
            $('#edit-routine-modal').on('show.bs.modal', function (e) {
                let btnEdit = $(e.relatedTarget);
                routineId = btnEdit.data('id');
                let title = btnEdit.data('title');
                let content = btnEdit.data('content');
                let modal = $(this);
                modal.find('#title').val(title);
                modal.find('#content').val(content);
            });

            // update modal
            $('#edit-routine').on('click', function () {

                let strUrl = '/routine/update/' + routineId;
                let modalID = 'edit-routine-modal';
                let objData = {
                    content: $('#'+modalID).find('#content').val(),
                    title: $('#'+modalID).find('#title').val(),
                    _token: $('#'+modalID).find('input[name=_token]').val()
                };

                let submitBtnID = 'edit-routine';
                let redirectUrl = '/routine/show/{{$goal->id}}';
                let successMsgTitle = 'Changes Saved!';
                let successMsg = 'Record has been updated successfully.';
                let Method = 'PATCH';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, Method);
            });

        });
		function clone(id, file_index, child_id) {
			var clone = document.getElementById(id).cloneNode(true);
			clone.setAttribute("id", file_index);
			clone.setAttribute("name", file_index);
			clone.style.display = "table-row";
			clone.querySelector('#' + child_id).setAttribute("name", child_id + '[' + file_index + ']');
			clone.querySelector('#' + child_id).disabled = false;
			clone.querySelector('#' + child_id).setAttribute("id", child_id + '[' + file_index + ']');
			return clone;
		}
		function addFile() {
			var table = document.getElementById("tab_tab");
			var file_index = document.getElementById("file_index");
			file_index.value = ++file_index.value;
			var file_clone = clone("file_row", file_index.value, "picture");
			var name_clone = clone("name_row", file_index.value, "hyper_link");
			var final_row = document.getElementById("final_row").cloneNode(false);
			table.appendChild(file_clone);
			table.appendChild(name_clone);
			table.appendChild(final_row);
			var total_files = document.getElementById("total_files");
			total_files.value = ++total_files.value;
			//change the following using jquery if necessary
			var remove = document.getElementsByName("remove");
			for (var i = 0; i < remove.length; i++)
				remove[i].style.display = "inline";
		}
		
		function removeFile(row_name)
		{
			var row=row_name.parentNode.parentNode.id;
			var rows=document.getElementsByName(row);
			while(rows.length>0)
				rows[0].parentNode.removeChild(rows[0]);
			var total_files = document.getElementById("total_files");
			total_files.value=--total_files.value;
			var remove=document.getElementsByName("remove");
			if(total_files.value == 1)
				remove[1].style.display='none';
		}
    </script>
@stop