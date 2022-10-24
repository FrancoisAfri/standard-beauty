<div class="row">
    <div class="col-md-12 col-md-offset-0">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-barcode pull-right"></i>
                <h3 class="box-title"> Progress</h3>
            </div>
            <div class="box-body">
                <div class="card my-2">
                </div>
                <div style="overflow-X:auto;">

                    <table id=" " class="progress table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Comment</th>
							<th>Created At</th>
                            <th>Images</th>
                            <th style="width: 5px; text-align: center;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($contact->progess) > 0)
                            <tr class="products-list product-list-in-box">
                                @foreach ($contact->progess as $key => $progess)
                                    <td>{{ $progess->comment}}</td>
                                    <td>{{ $progess->created_at}}</td>
									<td>
                                        <img src="{{ asset('storage/customer/progress/'.($progess->picture ?? '') ) }} "
                                             height="35px" width="40px" alt="">
                                    </td>
                                    <td>
                                    </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Comment</th>
							<th>Created At</th>
                            <th>Images</th>
                            <th style="width: 5px; text-align: center;"></th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



