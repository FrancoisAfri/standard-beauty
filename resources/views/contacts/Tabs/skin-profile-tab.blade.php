<div class="col-lg-6 col-sm-6 pull-left">
    <br>
    <br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-hover">
                <tbody>
                <tr><td colspan="2" style="text-align: center;"><strong>Skin Content</strong></td></tr>
				@foreach($contact->skinProfile as $profile)
					<tr>
						<td style="text-align: center;" colspan="2">
							{{$profile->content}}
						</td>
					</tr>
				@endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>