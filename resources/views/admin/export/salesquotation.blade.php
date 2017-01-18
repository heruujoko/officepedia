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
        }
        td, th {
            padding: 0;
        }
        td, th {
            display: table-cell;
            vertical-align: inherit;
        }
    .header-topright{
    position: absolute;
    top: 0%;
    right: 0%;
    }
    .cust{
        padding-top: 50px;
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
        margin-left: 300px;

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
                Website: {{ $config->msyscompwebsite }}<br>
                Phone: {{ $config->msyscompphone }}<br>
                Fax: {{ $config->msyscompfax }}<br>
                Supplier: {{ $quotation[0]['mhsalesquotationsupplierid'] }}<br>
            </td>
        </tr>
    </table>
    </div>

    {{-- TOP RIGHT --}}
    <div class="header-topright">
    <table border="">
        <tr>
            <th style=""></th>
        </tr>
        <tr>
            <td> 
                <h3 style="color: #9ACADE">Penawaran Pembelian</h3>
                DATE:  {{ $quotation[0]['mhsalesquotationdate'] }}<br>
                QUOTE:  {{ $quotation[0]['mhsalesquotationno'] }}<br>
                CUSTOMER ID:  {{ $quotation[0]['mhsalesquotationsupplierid'] }}<br>
                VALID UNTIL:  {{ $quotation[0]['mhsalesquotationduedate'] }}<br>
            </td>
        </tr>
    </table>
    </div>
    {{-- Customer --}}
    <table border="">
        <tr>
            <th style="background: #00E281; color: white;">Customer</th>
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
   
       <table class="table">
           <tr>
           <th style="background: #00E281; color: white;">Kode</th>
           <th style="background: #00E281; color: white;">Nama</th>
           <th style="background: #00E281; color: white;">Harga Beli</th>
           <th style="background: #00E281; color: white;">QTY</th>
           <th style="background: #00E281; color: white;">Jumlah Satuan</th>
           <th style="background: #00E281; color: white;">Diskon</th>
           <th style="background: #00E281; color: white;">Jumlah</th>
           </tr>
         
             @foreach($mdquotation as $a)
           
           <tr>
               <td class="tds">{{ $a->mdsalesquotationgoodsid }}</td>
               <td class="tds">{{ $a->mdsalesquotationgoodsname }}</td>
               <td class="tds">{{ number_format($a->mdsalesquotationbuyprice,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="tds">{{ $a->mdsalesquotationgoodsqty }}</td>
               <td class="tds">{{ $a->mdsalesquotationgoodsqty }}</td>
               <td class="tds">{{ number_format($a->mdsalesquotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="tds">{{ number_format($a->mdsalesquotationbuyprice * $a->mdsalesquotationgoodsqty - $a->mdsalesquotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
                
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
          
       
            @endforeach
            
       </table>
       <table class="balance">
                <tr>
                    <th><span contenteditable>Total Item :</span></th>
                    <td><span data-prefix></span><span>{{ $totalitem }}</span></td>
                </tr>

                <tr>
                    <th><span contenteditable>Sub Total :</span></th>
                    <td><span data-prefix>IDR </span><span contenteditable>{{ number_format($subtotal,$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Discount :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ number_format($discount,$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                 <tr>
                    <th><span contenteditable>PPN 10% :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ number_format($quotation[0]['mhsalesquotationtaxtotal'],$decimals,$dec_point,$thousands_sep) }}</span></td>
                </tr>
                 <tr>
                    <th><span contenteditable>Total :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ number_format($quotation[0]['mhsalesquotationgrandtotal'],$decimals,$dec_point,$thousands_sep)}}</span></td>
                </tr>
            </table>
    </div>
     <table class="table">
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
            <th style="background: #00E281; color: white;">TERMS AND CONDITIONS</th>
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

 