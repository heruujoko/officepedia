@extends('admin/nav/layout')
@section('title')
@section('content')

<!-- MAIN PANEL -->
<div id="main" role="main">

  <!-- RIBBON -->
  <div id="ribbon">

    <span class="ribbon-button-alignment">
      <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
        <i class="fa fa-refresh"></i>
      </span>
    </span>

    <!-- breadcrumb -->
    <ol class="breadcrumb">
      <li>Home</li><li>Cabang</li><li>Buat baru</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:

    <span class="ribbon-button-alignment pull-right">
    <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
    <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
    <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
    </span> -->

  </div>
  <!-- END RIBBON -->
</br>
</br>
</br>
</br>

		<form class="form-horizontal" action="#" method="post">
					{{ csrf_field() }}
          <div class="container">
            <div class="jumbotron">


					@if(count($errors) > 0)
		<div class="alert alert-danger">
		@foreach($errors->all() as $error)
			<ul>
				<li>{{ $error }}</li>
			</ul>
		@endforeach
		</div>
	@endif

  <div class="form-group">
  <label class="col-md-3 control-label">BRANCH CODE</label>
  <div class="col-md-8">
  <input name="mbranchcode" class="form-control" placeholder="BRANCH CODE" type="text">
  </div>
  </div>
  <div class="form-group">
	<label class="col-md-3 control-label">BRANCH NAME</label>
	<div class="col-md-8">
	<input name="mbranchname" class="form-control" placeholder="BRANCH NAME" type="text">
	</div>
	</div>
<center>
	<div class="row">
	<div class="col-md-12">
	<button class="btn btn-default" type="reset">Batal</button>
	<button class="btn btn-primary" type="submit">
	<i class="fa fa-save"></i>Simpan</button>
	</div>
	</div>
</center>
	</div>
  </div>

</div>
<!-- end widget content -->

</div>
<!-- end widget div -->

</div>
<!-- end widget -->



</article>
<!-- WIDGET END -->

</div>

<!-- end row -->

<!-- end row -->

</section>
<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

@stop
