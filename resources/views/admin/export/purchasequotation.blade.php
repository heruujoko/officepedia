<!DOCTYPE html>
<html>
<head>
<style>
    .header-status{
    position: absolute;
    top: 0%;
    right: 10%;
    }
     .header-status2{
    position: absolute;
    top: 5%;
    right: 10%;
    }
     .header-status3{
    position: absolute;
    top: 10%;
    right: 10%;
    }
     .header-status4{
    position: absolute;
    top: 15%;
    right: 10%;
    }
    .cust{
        padding-top: 90px;
    }
   

    .cust>table {
        width: 100%;
    }

    .cust>table>th {
        height: 50px;
    }

    .cust>table>td {
      
    }
    .balance{
        margin-left: 175px;
    }


</style>	
</head>
<body>
<div>
 	<h2>{{ $config->msyscompname }}</h2><br>
 	<label class="filter-status">{{ $config->msyscity }}, {{ $config->msyszipcode }}</label><br>
 	<label class="filter-status">Website: {{ $config->msyscompwebsite }}</label><br>
 	<label class="filter-status">Phone: {{ $config->msyscompphone }}</label><br>
 	<label class="filter-status">Fax: {{ $config->msyscompfax }}</label>
 	<label class="filter-status">Supplier: {{ $quotation->mhpurchasequotationsupplierid }}</label><br><br>
    {{-- TOP RIGHT --}}
    <div class="">
 	<label class="header-status">Date: {{ $quotation->mhpurchasequotationdate }}</label>
 	<label class="header-status2">Quote: {{ $quotation->mhpurchasequotationno }}</label>
 	<label class="header-status3">Customer ID: {{ $quotation->mhpurchasequotationsupplierid }}</label>
 	<label class="header-status4">Valid Until: {{ $quotation->mhpurchasequotationduedate }}</label>
    </div>
    {{-- Customer --}}
    <table border="">
        <tr>
            <th style="background: gray; color: black;">Customer</th>
        </tr>
        <tr>
            <td>
                Name: {{ $supplier->msuppliername }}<br>
                Address: {{ $supplier->msupplieraddress }}<br>
                City,ST,ZIP: {{ $supplier->msuppliercity }}, {{ $supplier->msupplierprovince }}, {{ $supplier->msupplierzipcode }}<br>
                Phone: {{ $supplier->msupplierphone }}<br>
            </td>
        </tr>
    </table>
    {{--  --}}
    <div class="cust">
   
       <table border="1">
           <tr>
           <th style="background: gray; color: black;">Description</th>
           <th style="background: gray; color: black;">Taxed</th>
           <th style="background: gray; color: black;">Amount</th>
           </tr>
             @foreach($mdquotation as $a)
           <tr>
               <td>{{ $a->mdpurchasequotationgoodsname }}</td>
               <td>{{ $quotation->mhpurchasequotationtaxtotal }}</td>
               <td>{{ $a->mdpurchasequotationgoodsqty }}</td>
        
           </tr>
            @endforeach
       </table>
       <table class="balance">
                <tr>
                    <th><span contenteditable>Subtotal :</span></th>
                    <td><span data-prefix>IDR</span><span>{{ $quotation->mhpurchasequotationsubtotal }}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Taxable :</span></th>
                    <td><span data-prefix>IDR</span><span contenteditable>{{ $quotation->mhpurchasequotationtaxtotal }}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Total Due :</span></th>
                    <td><span data-prefix>IDR</span><span>{{ $quotation->mhpurchasequotationgrandtotal }}</span></td>
                </tr>
            </table>
    </div>
    <table border="1">
        <tr>
            <th style="background: gray; color: black;">TERMS AND CONDITIONS</th>
        </tr>
        <tr>
        <td>
            1. Customer will be billed after indicating acceptance of this quote<br>
            2. Payment wil be due prio to delivery of service and goods<br>
            3. Please fax or mail the signed price quote to the address above<br>
            <pre>Customer Acceptance(sign below)</pre><br><br>
            <b>{{ $config->msyscompname }}</b><br>
            -------------------------------------<br>
            Print Name

        </td>
        </tr>
        
    </table>
 <center>
     <h6>If you have any question about this price quote, please contact</h6><br>
     <b>Thank You For Your Business!</b>
 </center>
</body>
</html>

 