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
    top: 5%;
    right: 0%;
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
        margin-left: 225px;

    }
    .footer{
        font-size: 11px;
    }

</style>	
</head>
<body>
<div>
    {{-- TOP LEFT --}}
 	<h3>{{ $config->msyscompname }}</h3><br>
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
                Supplier: {{ $quotation[0]['mhpurchasequotationsupplierid'] }}<br>
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
                <h3>Penawaran Pembelian</h3>
                Date: {{ $quotation[0]['mhpurchasequotationdate'] }}<br>
                Quote: {{ $quotation[0]['mhpurchasequotationno'] }}<br>
                Customer ID: {{ $quotation[0]['mhpurchasequotationsupplierid'] }}<br>
               Valid Until: {{ $quotation[0]['mhpurchasequotationduedate'] }}<br>
            </td>
        </tr>
    </table>
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
   
       <table class="table">
           <tr>
           <th style="background: gray; color: black;">Kode</th>
           <th style="background: gray; color: black;">Nama</th>
           <th style="background: gray; color: black;">Harga Beli</th>
           <th style="background: gray; color: black;">QTY</th>
           <th style="background: gray; color: black;">Jumlah Satuan</th>
           <th style="background: gray; color: black;">Diskon</th>
           <th style="background: gray; color: black;">Jumlah</th>
           </tr>
             @foreach($mdquotation as $a)
           <tr>
               <td class="tds">{{ $a->mdpurchasequotationgoodsid }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsname }}</td>
               <td class="tds">{{ $a->mdpurchasequotationbuyprice }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsunit1 }}</td>
               <td class="tds">{{ $a->mdpurchasequotationgoodsdiscount }}</td>
               <td class="tds">{{ $quotation[0]['mhpurchasequotationsubtotal'] }}</td>
                
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
                    <td><span data-prefix></span><span>{{ count($quotation[0]['mhpurchasequotationsupplierid']) }}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Sub Total :</span></th>
                    <td><span data-prefix>IDR </span><span contenteditable>-{{ $quotation[0]['mhpurchasequotationtaxtotal'] }}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Discount :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ $quotation[0]['mhpurchasequotationdiscounttotal'] }}</span></td>
                </tr>
                 <tr>
                    <th><span contenteditable>PPN 10% :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ $quotation[0]['mhpurchasequotationtaxtotal'] }}</span></td>
                </tr>
                 <tr>
                    <th><span contenteditable>Total :</span></th>
                    <td><span data-prefix>IDR </span><span>{{ $quotation[0]['mhpurchasequotationgrandtotal']}}</span></td>
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
            <th style="background: gray; color: black;">TERMS AND CONDITIONS</th>
        </tr>
        <tr>
        <td>
           {{ $config->msyspurchinvfootnote }}
           

        </td>
        </tr>
        
    </table>
 <center>
     <h6>If you have any question about this price quote, please contact</h6><br>
     <b>Thank You For Your Business!</b>
 </center>
 <div class="footer">
     <p>Dicetak oleh: {{ Auth::user()->name }}</p>
     <p>Tanggal Cektak: {{ $carbon }}</p>
 </div>
</body>
</html>

 