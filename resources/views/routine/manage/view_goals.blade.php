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
                    <h3 class="box-title">Manage Goals </h3>
                </div>
                <div class="box-body">
                    <div class="box-header">
                        <div class="form-group container-sm">
                            <form class="form-horizontal" method="get" action="{{ route('index') }}">
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
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-left">Submit</button><br>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                data-target="#add-client-modal">Add Goal
                        </button>
                    </div>
                    <div style="overflow-X:auto;">
                        <table id=" " class="client table table-bordered data-table my-2">
                            <thead>
                            <tr>
                                <th style="width: 10px; text-align: center;"></th>
                                <th>Title</th>
                                <th>Description</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($goals) > 0)
                                <ul class="products-list product-list-in-box">
                                    @foreach ($goals as $key => $goal)
                                        <tr id="categories-list">
                                            <td nowrap>
                                                <button type="button" id="edit_licence"
                                                        class="btn btn-warning  btn-xs"
                                                        data-toggle="modal" data-target="#edit-client-modal"
                                                        data-id="{{ $goal->id }}"
                                                        data-title="{{ $goal->title }}"
                                                        data-description="{{$goal->description}}"
														<i class="fa fa-pencil-square-o"></i> Edit
                                                </button>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" title="Click to View Routines"
                                                   href="{{ route('routine.show', $goal->id)}}">
                                                    {{ (!empty( $goal->title)) ?  $goal->title : ''}}
                                                </a>
                                            </td>
                                            <td>
                                                {{ (!empty( $goal->description)) ?  $goal->description : ''}}
                                            </td>
											<td style="text-align: center;">
												<button type="button" id="view_ribbons" class="btn {{ (!empty($goal->status) && $goal->status == 1) ? " btn-danger " : "btn-success " }}
											btn-xs" onclick="postData({{$goal->id}}, 'actdeac');"><i class="fa {{ (!empty($goal->status) && $goal->status == 1) ?
											"fa-times " : "fa-check " }}"></i> {{(!empty($goal->status) && $goal->status == 1) ? "De-Activate" : "Activate"}}</button>
                                            </td>
                                            <td>
                                                <form action="{{ route('routine.goal.destroy', $goal->id) }}"
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
                                <th>Description</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 5px; text-align: center;"></th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" id="cat_module" class="btn btn-default pull-right" data-toggle="modal"
                                    data-target="#add-client-modal">Add Goal
                            </button>
                        </div>
                    </div>
                </div>
                @include('routine.partials.create')
                @include('routine.partials.edit')
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
            if (data === 'actdeac') location.href = "{{route('routine.goal.activate', '')}}" + "/" + id;
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
            $('table.client').DataTable({
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
            $('#add-client').on('click', function () {
                let strUrl = '{{route('store')}}';
                let modalID = 'add-client-modal';
                let formName = 'add-client-form';
                //console.log(formName)
                let submitBtnID = 'add-client';
                let redirectUrl = '{{ route('index') }}';
                let successMsgTitle = 'Goal Added!';
                let successMsg = 'Record has been updated successfully.';
                modalFormDataSubmit(strUrl, formName, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg);
            });
            // show modal info
            let clientId;
            $('#edit-client-modal').on('show.bs.modal', function (e) {
                let btnEdit = $(e.relatedTarget);
                clientId = btnEdit.data('id');
                let title = btnEdit.data('title');
                let description = btnEdit.data('description');
                let modal = $(this);
                modal.find('#title').val(title);
                modal.find('#description').val(description);
            });
            // update modal
            $('#edit-client').on('click', function () {
                let strUrl = '/routine/goal/update/' + clientId;
                let modalID = 'edit-client-modal';
                let objData = {
                    description: $('#'+modalID).find('#description').val(),
                    title: $('#'+modalID).find('#title').val(),
                    _token: $('#'+modalID).find('input[name=_token]').val()
                };
                let submitBtnID = 'edit-client';
                let redirectUrl = '{{ route('index') }}';
                let successMsgTitle = 'Changes Saved!';
                let successMsg = 'Record has been updated successfully.';
                let Method = 'PATCH';
                modalAjaxSubmit(strUrl, objData, modalID, submitBtnID, redirectUrl, successMsgTitle, successMsg, Method);
            });
        });
    </script>
@stop