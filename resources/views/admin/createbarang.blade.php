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
      <li>Home</li><li>Barang</li><li>Buat baru</li>
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
<header>

<ul id="widget-tab-1" class="nav nav-tabs">
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
                     <div class="col-md-10">
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
                           <input name="mgoodsbranches" type="radio">
                           YES </label>
                         <label class="radio radio-inline">
                           <input name="mgoodsbranches" type="radio">
                           NO </label>
                       </div>
                     </div>

       <div class="form-group">
                   <label class="col-md-3 control-label">GOODS ACTIVE :</label>
                   <div class="col-ms-5">
                     <label class="checkbox-inline">
                       <input name="mgoodsactive" type="checkbox">
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
                 <input name="mgoodsuniquetransaction" type="checkbox">
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
                 <input name="mgoodspicture" type="checkbox">
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

   </article>
   <!-- WIDGET END -->

 </div>

 <!-- end row -->

 </form>
     <!-- end widget body text-->
 </div>
 </div>
 <!-- end widget content -->

 </div>
 <!-- end widget div -->

 </div>
 <!-- end widget -->


@stop
