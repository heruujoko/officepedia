
@extends('admin/nav/layouttables')
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
			<li>Home</li><li>BARANG</li><li>Data Barang</li>
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

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						BARANG
					<span>
						Data Barang
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
				<ul id="sparks" class="">
					<li class="sparks-info">
						<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
						<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
							1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
						</div>
					</li>
					<li class="sparks-info">
						<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>
						<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div>
					</li>
					<li class="sparks-info">
						<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>
						<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master Barang </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<form class="form-horizontal" action="{{URL::to('/')}}/admin-nano/tambahbarang" method="post">
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
								<header>

								<ul id="widget-tab-1" class="nav nav-pills">

								  <li class="active"><a data-toggle="tab" href="#hr1"><span class="hidden-mobile hidden-tablet"> Spesifikasi </span></a></li>
								  <li><a data-toggle="tab" href="#hr2"><span class="hidden-mobile hidden-tablet"> Satuan </span></a></li>
								  <li><a data-toggle="tab" href="#hr3"><span class="hidden-mobile hidden-tablet"> Supplier </span></a></li>
								  <li><a data-toggle="tab" href="#hr4"><span class="hidden-mobile hidden-tablet"> Harga </span></a></li>
								  <li><a data-toggle="tab" href="#hr5"><span class="hidden-mobile hidden-tablet"> Pajak </span></a></li>
								  <li><a data-toggle="tab" href="#hr6"><span class="hidden-mobile hidden-tablet"> Gambar </span></a></li>
								</ul>
								</header>
								  <!-- widget div-->
								<div>

								  <!-- widget edit box -->
								  <div class="jarviswidget-editbox">
								    <!-- This area used as dropdown edit box -->

								  </div>
								  <!-- end widget edit box -->

								  <!-- widget content -->
								  <div class="widget-body no-padding">

								    <!-- widget body text-->
								  </br>
									</br>
									</br>
								     <div class="tab-content padding-10">
								       <div class="tab-pane fade in active" id="hr1">
								            <div class="form-group">
								             <label name="mgoodscode" class="col-md-3 control-label">GOODS CODE :</label>
								             <div class="col-sm-5">
								               <input  name="mgoodscode" class="form-control" placeholder="GOODS CODE" type="text">
								             </div>
								           </div>
								           <div class="form-group">
								             <label name="mgoodsbarcode" class="col-md-3 control-label">GOODS BAR CODE :</label>
								             <div class="col-sm-5">
								               <input name="mgoodsbarcode" class="form-control" placeholder="GOODS BAR CODE" type="text">
								             </div>
								           </div>
								           <div class="form-group">
								             <label name="mgoodsname" class="col-md-3 control-label">GOODS NAME :</label>
								             <div class="col-sm-5">
								               <input name="mgoodsname" class="form-control" placeholder="GOODS NAME" type="text">
								             </div>
								           </div>
								           <div class="form-group">
								             <label name="mgoodsalias" class="col-md-3 control-label">GOODS ALIAS :</label>
								             <div class="col-sm-5">
								               <input name="mgoodsalias" class="form-control" placeholder="GOODS ALIAS" type="text">
								             </div>
								           </div>
								           <div class="form-group">
								             <label name="goodstype" class="col-md-3 control-label">GOODS TYPE :</label>
								             <div class="col-sm-5">
								               <input name="mgoodstype" class="form-control" placeholder="GOODS TYPE" type="text">
								             </div>
								           </div>

								           <div class="form-group">
								                       <label class="control-label col-md-3" for="prepend">GOODS GROUP 1 :</label>
								                       <div class="col-sm-5">
								                       <div class="icon-addon addon-md">
								                         <input name="mgoodsgroup1" type="text" placeholder="GOODS GROUP 1" class="form-control">
								                         <label for="mgoodsgroup1" class="glyphicon glyphicon-search" rel="tooltip" title="GOODS GROUP 1"></label>
								                       </div>
								                     </div>
								                     </div>

								             <div class="form-group">
								                     <label class="control-label col-md-3" for="prepend">GOODS GROUP 2 :</label>
								                     <div class="col-sm-5">
								                     <div class="icon-addon addon-md">
								                       <input name="mgoodsgroup2" type="text" placeholder="GOODS GROUP 2" class="form-control">
								                       <label for="mgoodsgroup2" class="glyphicon glyphicon-search" rel="tooltip" title="GOODS GROUP 2"></label>
								                     </div>
								                   </div>
								                   </div>

								           <div class="form-group">
								                   <label class="control-label col-md-3" for="prepend">GOODS GROUP 3 :</label>
								                   <div class="col-sm-5">
								                   <div class="icon-addon addon-md">
								                     <input name="mgoodsgroup3" type="text" placeholder="GOODS GROUP 3" class="form-control">
								                     <label for="mgoodsgroup3" class="glyphicon glyphicon-search" rel="tooltip" title="GOODS GROUP 3"></label>
								                   </div>
								                 </div>
								                 </div>
								                 <fieldset>
								                   <div class="form-group">
								                     <label name="mgoodsremark" class="col-md-3 control-label">GOODS REMARK :</label>
								                     <div class="col-md-5">
								                       <textarea class="form-control" placeholder="GOODS REMARK" name="mgoodsremark" rows="8"></textarea>
								                     </div>
								                   </div>
								                 </fieldset>
								           <!-- <div class="form-group">
								             <label class="col-md-3 control-label">GOODS REMARK :</label>
								             <div class="col-md-10">
								               <input name="mgoodsremark" class="form-control" type="text">
								             </div>
								           </div> -->

								           <div class="form-group">
								                       <label class="col-md-3 control-label">GOODS BRANCHES :</label>
								                       <div class="col-sm-5">
																				 <label class="radio radio-inline">
								                           <input name="mgoodsbranches" type="radio" checked>
								                           NO </label>
								                         <label class="radio radio-inline">
								                           <input name="mgoodsbranches" type="radio">
								                           YES </label>
								                       </div>
								                     </div>

								       <div class="form-group">
								                   <label class="col-md-3 control-label">GOODS ACTIVE :</label>
								                   <div class="col-ms-5">
								                     <label class="checkbox-inline">
								                       <input name="mgoodsactive" type="checkbox" checked>
								                       ACTIVE </label>
								                   </div>
								                 </div>

								           <button type="submit" name="button" class="btn btn-primary">CREATE</button>
								       </div>

								       <div class="tab-pane fade" id="hr2">
								           <div class="form-group">
								             <label name="mgoodsunit" class="col-md-3 control-label">GOODS UNIT :</label>
								             <div class="col-sm-5">
								               <input name="mgoodsunit" class="form-control" placeholder="GOODS UNIT" type="text">
								             </div>
								           </div>

								             <div class="form-group">
								               <label name="mgoodsunit2" class="col-md-3 control-label">GOODS UNIT 2 :</label>
								               <div class="col-sm-5">
								                 <input name="mgoodsunit2" class="form-control" placeholder="GOODS UNIT 2" type="text">
								               </div>
								             </div>

								             <div class="form-group">
								               <label name="mgoodsunit2convert" class="col-md-3 control-label">GOODS UNIT 2 CONVERT :</label>
								               <div class="col-sm-5">
								                 <input name="mgoodsunit2convert" class="form-control" placeholder="GOODS UNIT 2 CONVERT" type="text">
								               </div>
								             </div>

								               <div class="form-group">
								                 <label name="mgoodsunit3" class="col-md-3 control-label">GOODS UNIT 3 :</label>
								                 <div class="col-sm-5">
								                   <input name="mgoodsunit3" class="form-control" placeholder="GOODS UNIT 3" type="text">
								                 </div>
								               </div>

								               <div class="form-group">
								                 <label name="mgoodsunit3convert" class="col-md-3 control-label">GOODS UNIT 3 CONVERT :</label>
								                 <div class="col-sm-5">
								                   <input name="mgoodsunit3convert" class="form-control" placeholder="GOODS UNIT 3 CONVERT" type="text">
								                 </div>
								               </div>
								             </br>
								           </br>
								         </br>
								       </br>
								     </br>
								   </br>
								 </br>
								</br>
								       </div>

								       <div class="tab-pane fade" id="hr3">
								         <div class="form-group">
								           <label name="mgoodssuppliercode" class="col-md-3 control-label">GOODS SUPPLIER CODE :</label>
								           <div class="col-sm-5">
								             <input name="mgoodssuppliercode" class="form-control" placeholder="GOODS SUPPLIER CODE" type="text">
								           </div>
								         </div>
								         <div class="form-group">
								           <label name="mgoodssuppliername" class="col-md-3 control-label">GOODS SUPPLIER NAME :</label>
								           <div class="col-sm-5">
								             <input name="mgoodssuppliername" class="form-control" placeholder="GOODS SUPPLIER NAME" type="text">
								           </div>
								         </div>
								         <div class="form-group">
								           <label name="mgoodsbrand" class="col-md-3 control-label">GOODS BRAND :</label>
								           <div class="col-sm-5">
								             <input name="mgoodsbrand" class="form-control" placeholder="GOODS BRAND" type="text">
								           </div>
								         </div>

								         <div class="form-group">
								           <label name="mgoodscogs" class="col-md-3 control-label">GOODS COGS :</label>
								           <div class="col-sm-5">
								             <input name="mgoodscogs" class="form-control" placeholder="GOODS COGS" type="text">
								           </div>
								         </div>

								         <div class="form-group">
								             <label class="col-md-3 control-label">GOODS UNIQUE TRANSACTION :</label>
								             <div class="col-ms-5">
								               <label name="mgoodsuniquetransaction" class="checkbox-inline">
								                 <input name="mgoodsuniquetransaction" type="checkbox" checked>
								                 UNIQUE TRANSACTION </label>
								             </div>
								           </div>
								         </br>
								       </br>
								     </br>
								   </br>
								 </br>
								</br>
								</br>
								</br>
								         </div>

								       <div class="tab-pane fade" id="hr4">
								         <div class="form-group">
								           <label name="mgoodspricein" class="col-md-3 control-label">GOODS PRICE IN :</label>
								           <div class="col-sm-5">
								             <input name="mgoodspricein" class="form-control" placeholder="GOODS PRICE IN" type="text">
								           </div>
								         </div>
								         <div class="form-group">
								           <label name="mgoodspriceout" class="col-md-3 control-label">GOODS PRICE OUT :</label>
								           <div class="col-sm-5">
								             <input name="mgoodspriceout" class="form-control" placeholder="GOODS PRICE OUT" type="text">
								           </div>
								         </div>
								       </br>
								     </br>
								   </br>
								 </br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								       </div>

								       <div class="tab-pane fade" id="hr5">
								         <div class="form-group">
								           <label name="mgoodscoapurchasingname" class="col-md-4 control-label">GOODS PURCASHING NAME :</label>
								           <div class="col-sm-5">
								             <input name="mgoodscoapurchasingname" class="form-control" placeholder="GOODS PURCHASHING NAME" type="text">
								           </div>
								         </div>

								         <div class="form-group">
								           <label name="mgoodscoacogsname" class="col-md-4 control-label">GOODS COA COGS NAME :</label>
								           <div class="col-sm-5">
								             <input name="mgoodscoacogsname" class="form-control" placeholder="GOODS COA COGS NAME" type="text">
								           </div>
								         </div>
								         <div class="form-group">
								           <label name="mgoodscoasellingname" class="col-md-4 control-label">GOODS COA SELLING NAME:</label>
								           <div class="col-sm-5">
								             <input name="mgoodscoasellingname" class="form-control" placeholder="GOODS COA SELLING NAME" type="text">
								           </div>
								         </div>
								         <div class="form-group">
								           <label name="mgoodscoareturnofsellingname" class="col-md-4 control-label">GOODS COA RETURN OF SELLING NAME :</label>
								           <div class="col-sm-5">
								             <input name="mgoodscoareturnofsellingname" class="form-control" placeholder="GOODS COA RETURN OF SELLING NAME" type="text">
								           </div>
								         </div>
								       </br>
								     </br>
								   </br>
								 </br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>

								       </div>

								       <div class="tab-pane fade" id="hr6">
								         <div class="form-group">
								             <label class="col-md-3 control-label">GOODS PICTURE :</label>
								             <div class="col-ms-5">
								               <label name="mgoodsuniquetransaction" class="checkbox-inline">
								                 <input name="mgoodspicture" type="checkbox" checked>
								                 Default </label>
								             </div>
								           </div>
								         </br>
								       </br>
								     </br>
								   </br>
								 </br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>

								 </form>
							 </div>
	 						<!-- end widget content -->

	 					</div>
	 					<!-- end widget div -->

	 				</div>
	 				<!-- end widget -->



	 			</article>
	 			<!-- WIDGET END -->

	 		</div>


		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master Barang </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">

											<thead>
										<tr>
											<th class="hasinput" style="width:7%">
												<input type="text" class="form-control" placeholder="Filter NO" />
											</th>
											<th class="hasinput" style="width:18%">
													<input type="text" class="form-control" placeholder="Filter GOODS CODE" />
													</th>
											<th class="hasinput" style="width:14%">
												<input type="text" class="form-control" placeholder="Filter GOODS BAR CODE" />
											</th>
											<th class="hasinput" style="width:14%">
												<input type="text" class="form-control" placeholder="Filter GOODS NAME" />
											</th>
											<th class="hasinput" style="width:14%">
												<input type="text" class="form-control" placeholder="Filter GOODS ALIAS" />
											</th>
											<th class="hasinput" style="width:15%">

											</th>
										</tr>
													<tr>
																<th data-class="expand">NO</th>
																<th data-hide="phone">GOODS CODE</th>
																<th data-hide="phone,tablet">GOODS BAR CODE</th>
																<th data-hide="phone,tablet">GOODS NAME</th>
																<th data-hide="phone,tablet">GOODS ALIAS</th>
																<th data-hide="phone,tablet">ACTION</th>
													</tr>
											</thead>

									        <tbody>
                            <?php $i=1; ?>
                            @foreach($a as $data)
									            <tr>
									                <td><?php echo $i; ?></td>
									                <td>{{$data->mgoodscode}}</td>
									                <td>{{$data->mgoodsbarcode}}</td>
									                <td>{{$data->mgoodsname}}</td>
									                <td>{{$data->mgoodsalias}}</td>
                                  <td>

																		<div class="button">
																			<a href="#" class="btn btn-info btn-xs dropdown-toggle fa fa-eye">Details</a>
																			<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" href="{{ URL::to('/') }}/admin-nano/editcabang/{{ $data->id }}/edit">Edit</a>
																			<a  class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('{{ $data->id }}')">Hapus</a>
																		</div>

            	</td>

			</tr>
<?php $i++ ?>
@endforeach
    </tr>
                    	</tbody>

                </table>


<a href="{{URL::to('/')}}/admin-nano/tambahbarang" class="btn btn-primary">INSERT</a>
								<script>
														function popupdelete(id){
																console.log('click');
																var choice = confirm('Anda yakin akan menghapus ?');
																if(choice){
																		  window.location = '{{ URL::to('/') }}'+'/admin-nano/delbarang/'+id+'/delete';
																}
														}
										</script>
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
