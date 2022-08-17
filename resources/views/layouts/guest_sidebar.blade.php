<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Company logo (optional) -->
        <img src="{{ $company_logo }}" width="100%" class="img-responsive" alt="Company Logo">
        <!-- End Company logo (optional) -->

        <!-- Sidebar user panel (optional) --
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/bower_components/AdminLTE/dist/img/avatar.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin User</p>
                <!-- Status --
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- End Sidebar user panel (optional) -->

        <!-- search form (Optional) --
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
		<ul class="sidebar-menu" style=" overflow-y: scroll;">
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <!-- Optionally, you can add icons to the links -->
			<div> 
				<div >
					@if (!empty($news))
						<div class="item active"> <!-- item 1 -->
							<a href="{{$news->link}}" id="view"
								target="_blank"><i class=""></i> <img class="img-responsive pad" src="{{ Storage::disk('local')->url("CMS/images/$news->image") }}" width="230">
							</a>
						</div>
					@endif
					<hr>
					@if (!empty($secondNews))
						<div class="item active"> <!-- item 1 -->
							<a href="{{$secondNews->link}}" id="view"
								target="_blank"><i class=""></i> <img class="img-responsive pad" src="{{ Storage::disk('local')->url("CMS/images/$secondNews->image") }}" width="230">
							</a>
						</div>
					@endif
				</div>
			</div>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>