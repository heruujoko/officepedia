<!DOCTYPE html>
<html>
<head>
<style>
    table th {
            font-size: 11px;
        }
        .tds {
            font-size: 10px;
            text-align: center;
        }
        table>td {
            font-size: 11px;
          
        }
        
        table {
            background-color: transparent;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        *, :after, :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            height: 1%;
        }
        .table>tbody tr:nth-child(even) {
        background: #f0f0f2;

        }
        td, th {
            padding: 0;
        }
        td, th {
            display: table-cell;
            vertical-align: inherit;
        }
        .table>tfoot {
          text-align: right;
        }
        .table>tfoot tr:last-child {
          background: #f0f0f2;
        }
       .bb td, .bb th {
     border-bottom: 1px solid black !important;

    }

    .header-topright{
    position: fixed;
    top: 1%;
    left: 73%;
    }
    .cust{
        padding-top: 50px;
    }
   

    .cust>table {
        width: 100%;
    }

    .cust>table>th {
        height: 30px;
    }

    .cust>table>td {
      
    }
    .balance{
        margin-left: 320px;

    }
    .footer{
        font-size: 11px;
    }
    .top-left{
      
    }
    .global-css{
         font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
         font-size: 10px;
    }
    .thnoborder{
        border-style:hidden;

    }
</style>	
</head>
<body class="global-css">
<div class="top-left">
    {{-- TOP LEFT --}}
 	<h3 style="color: #257293">{{ $config->msyscompname }}</h3>
    <table border="">
        <tr>
            <th style=""></th>
        </tr>
        <tr>
            <td>
               {{ $config->msyscity }}, {{ $config->msyszipcode }}<br>
                Website : {{ $config->msyscompwebsite }}<br>
                Phone : {{ $config->msyscompphone }}<br>
                Fax: {{ $config->msyscompfax }}<br>
                Supplier : {{ $quotation[0]['mhpurchasequotationsupplierid'] }}<br>
            </td>
        </tr>
    </table>
    </div>

    {{-- TOP RIGHT --}}
    <div class="header-topright">
     <h3 style="color: #217293">Pesanan Pembelian</h3>
    <table border="" cellpadding="5" cellpadding="5">
        <tr>
            <th style=""></th>
        </tr>
      
        <tr>
            <th style="text-align: right;" class="thnoborder">DATE : </td>
            <td>{{ $quotation[0]['mhpurchasequotationdate'] }}</td>
        </tr>
        <tr>
            <th style="text-align: right;" class="thnoborder">QUOTE : </td>
            <td>{{ $quotation[0]['mhpurchasequotationno'] }}</td>
        </tr>
        <tr>
            <th style="text-align: right;" class="thnoborder">CUSTOMER ID :</td>
            <td>{{ $quotation[0]['mhpurchasequotationsupplierid'] }}</td>
        </tr>
        <tr>
            <th style="text-align: right;" class="thnoborder">VALID UNTIL : </td>
            <td>{{ $quotation[0]['mhpurchasequotationduedate'] }}</td>
        </tr>
    </table>
    </div>
    {{-- Customer --}}
    <table border="">
        <tr>
            <th style="background: #089DDD; color: white;">Customer</th>
        </tr>
        <tr>
            <td>
                Name : {{ $supplier->msuppliername }}<br>
                Address : {{ $supplier->msupplieraddress }}<br>
                City,ST,ZIP : {{ $supplier->msuppliercity }}, {{ $supplier->msupplierprovince }}, {{ $supplier->msupplierzipcode }}<br>
                Phone : {{ $supplier->msupplierphone }}<br>
            </td>
        </tr>
    

    </table>
    {{--  --}}
    <div class="cust">
   
       <table class="table">
       <thead>
           <tr>
           <th style="background: #089DDD; color: white;">Kode</th>
           <th style="background: #089DDD; color: white;">Nama</th>
           <th style="background: #089DDD; color: white;">Harga Beli</th>
           <th style="background: #089DDD; color: white;">QTY</th>
           <th style="background: #089DDD; color: white;">Jumlah Satuan</th>
           <th style="background: #089DDD; color: white;">Diskon</th>
           <th style="background: #089DDD; color: white;">Jumlah</th>
           </tr>
         </thead>
         <tbody>
             @foreach($mdquotation as $a)
           
           <tr>
               <td class="tds">{{ $a->mdpurchasequotationgoodsid }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsname }}</td>
               <td class="tds">{{ number_format($a->mdpurchasequotationbuyprice,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td class="tds">{{ number_format($a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="tds">{{ number_format($a->mdpurchasequotationbuyprice * $a->mdpurchasequotationgoodsqty - $a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
                
           </tr>
       
            @endforeach
              <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
           
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
        
          
       
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          
            <tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
           </tr>
          <tfoot>
             <tr>
                    <td colspan="6"><span contenteditable>Total Item :</span></td>
                    <td><span data-prefix></span><span>{{ $totalitem }}</span></td>
                </tr>

                <tr>
                    <td colspan="6"><span contenteditable>Sub Total :</span></td>
                    <td><span data-prefix>IDR </span><span contenteditable>{{ number_format($subtotal,$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                <tr>
                    <td colspan="6"><span contenteditable>Discount :</span></td>
                    <td><span data-prefix>IDR </span><span>{{ number_format($discount,$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                 <tr class="bb">
                    <td colspan="6"><span contenteditable>PPN 10% :</span></td>
                    <td><span data-prefix>IDR </span><span>{{ number_format($quotation[0]['mhpurchasequotationtaxtotal'],$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                 <tr>
                    <td colspan="6"><span contenteditable>Total :</span></td>
                    <td><span data-prefix>IDR </span><span>{{ number_format($quotation[0]['mhpurchasequotationgrandtotal'],$decimals,$dec_point,$thousands_sep)}}</span></td>
                </tr>
          </tfoot>
              </tbody>
       
       </table>
      
    </div>
    <br>
    <br>
     <table class="tables">
        <tr>
            <td>
                <pre>Customer Acceptance(sign below)</pre><br><br>
            
            -------------------------------------<br>
            Print Name
            </td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <th style="background: #089DDD; color: white;">TERMS AND CONDITIONS</th>
        </tr>
        <tr>
        <td>

           {!! $config->msyspurchinvfootnote !!}
           

        </td>
        </tr>
        
    </table>
 <center>
     <h4>If you have any question about this price quote, please contact</h4><br>
     <b>Thank You For Your Business!</b>
 </center>
 <div class="footer">
     <p>Dicetak oleh: {{ Auth::user()->name }}</p>
     <p>Tanggal Cektak: {{ $carbon }}</p>
 </div>
</body>
</html>

 