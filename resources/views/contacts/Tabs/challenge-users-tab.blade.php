<div class="row">
    <div class="col-md-12 col-md-offset-0">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-barcode pull-right"></i>
                <h3 class="box-title"> Users</h3>
            </div>
            <div class="box-body">
                <div class="card my-2">
                </div>
                <div style="overflow-X:auto;">

                    <table id=" " class="users table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Names</th>
							<th style="width: 5px; text-align: center;"> Created At</th>
                            <th style="width: 5px; text-align: center;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($challenge->users) > 0)
                            <tr class="products-list product-list-in-box">
                                @foreach ($challenge->users as $key => $user)
                                   <td>{{ $user->user->firstname." ".$user->user->surname}}</td>
                                   <td>{{ !empty($user->created_at) ? $user->created_at : ''}}</td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Names</th>
							<th style="width: 5px; text-align: center;"> Created At</th>
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