<div class="row">
    <div class="col-md-12 col-md-offset-0">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-barcode pull-right"></i>
                <h3 class="box-title"> Reminders</h3>
            </div>
            <div class="box-body">
                <div class="card my-2">
                </div>
                <div style="overflow-X:auto;">
                    <table id=" " class="progress table table-bordered table-hover">
                        <thead>
							<tr>
								<th>Title</th>
								<th>Notes</th>
								<th>Day Of Week</th>
								<th>Time</th>
								<th>Created At</th>
								<th style="width: 5px; text-align: center;"></th>
							</tr>
                        </thead>
                        <tbody>
							@if (count($contact->reminder) > 0)
								<tr class="products-list product-list-in-box">
									@foreach ($contact->reminder as $key => $reminder)
										<td>{{ $reminder->title}}</td>
										<td>{{ $reminder->notes}}</td>
										<td>{{ $reminder->day_of_week}}</td>
										<td>{{ $reminder->time}}</td>
										<td>{{ $reminder->created_at}}</td>
										<td>
										</td>
								</tr>
								@endforeach
							@endif
                        </tbody>
                        <tfoot>
							<tr>
								<th>Title</th>
								<th>Notes</th>
								<th>Day Of Week</th>
								<th>Time</th>
								<th>Created At</th>
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