<!DOCTYPE html>
<html>
<head>
<style>
    table th {
            font-size: 11px;
        }
        .tds {

            text-align: center;
            height: 1px !important;
        }
        table>td {
            font-size: 11px;

        }
        table {
           background-color: transparent;
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
            line-height: 5px;
            vertical-align: top;

            height: 3px !important;
            font-size: 9px !important;
        }
        .table>tbody tr:nth-child(even) {
        background: #f0f0f2;
        }
        td, th {
            display: table-cell;
            vertical-align: inherit;
            padding: 0;
        }
        .table>tfoot {
          text-align: right;

        }


    .header-topright{
    position: fixed;
    top: -2%;
    left: 68%;
    }
    .cust{
        padding-top: 10px;

    }


    .cust>table {
        width: 101%;
    }


    .cust>table>td {

    }
    .balance{
        margin-left: 320px;

    }
    .footer{
    width: 600px;
    position: fixed;
    bottom: 0;
    left: 33%;
    margin-left: -300px;
}
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
    .signbelow{

    width: 330;
    border: 2px solid black;
    padding: 5px;

    }
    .footertos{
       padding-top: -120px;
    }
    .tdborder{
      border: 1px solid black;
    }
    .col-border{
      border-left: 1px solid #000;
      border-right: 1px solid #000;
    }

</style>
</head>
<body class="global-css">
<div class="top-left">
    {{-- TOP LEFT --}}
 	<h1 style="color: #257293">{{ $config->msyscompname }}</h1>
    <table border="" cellpadding="5" cellpadding="5">
        <tr>
            <th style=""></th>
        </tr>
        <tr>
        <td style="text-align: right;"></td>
          <td>
            {{ $config->msysstreet }}
          </td>
        </tr>
        <tr>
        <td style="text-align: right;"></td>
            <td>
               {{ $config->msyscity }}, {{ $config->msyszipcode }}
            </td>
        </tr>
        <tr>
        <td style="text-align: right;">Website :</td>
            <td>
                 {{ $config->msyscompwebsite }}
            </td>
        </tr>
         <tr>
         <td style="text-align: right;">Phone :</td>
             <td>
                 {{ $config->msyscompphone }}
            </td>
          </tr>
          <tr>
          <td style="text-align: right;">Fax :</td>
            <td>
                 {{ $config->msyscompfax }}
            </td>
          </tr>
          <tr>
          <td style="text-align: right;">Supplier :</td>
            <td>
                 {{ $quotation[0]['mhpurchasequotationsupplierid'] }}
            </td>
        </tr>
    </table>
    </div>

    {{-- TOP RIGHT --}}

<div class="header-topright">
     <h1 style="padding-top: 25px;" style="color: #217293">Pesanan Pembelian</h1>
    <table border="" cellpadding="5" cellpadding="5">
        <tr>
            <th style=""></th>
        </tr>

        <tr>
            <th style="text-align: left;" class="thnoborder">DATE</th>
            <th style="text-align: right;">:</th>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationdate'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">QUOTE</th>
            <th style="text-align: right;">:</th>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationno'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">CUSTOMER ID</th>
            <th style="text-align: right;">:</th>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationsupplierid'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">VALID UNTIL</th>
            <th style="text-align: right;">:</th>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationduedate'] }}</td>
        </tr>
    </table>
  </div>

    <br>
    {{-- Customer --}}
    <table border="" cellpadding="5" cellpadding="5">
      <tr>
            <th style=""></th>
        </tr>

        <tr>
        <td style="text-align: right;">Name :</td>
            <td>
                 {{ $supplier->msuppliername }}
            </td>
        </tr>
        <tr>
        <td style="text-align: right;">Address :</td>
            <td>
                 {{ $supplier->msupplieraddress }}
            </td>
        </tr>
        <tr>
        <td style="text-align: right;"></td>
            <td>
                 {{ $supplier->msuppliercity }}, {{ $supplier->msupplierprovince }}, {{ $supplier->msupplierzipcode }}
            </td>
        </tr>
        <tr>
        <td style="text-align: right;">Phone :</td>
            <td>
                 {{ $supplier->msupplierphone }}
            </td>
        </tr>


    </table>
    {{--  --}}
    <div class="cust">
      <table class="table">
       <thead>
           <tr>
           <th class="col-border" style="background: #089DDD; color: white;">KODE</th>
           <th class="col-border" style="background: #089DDD; color: white;">NAMA</th>
           <th class="col-border" style="background: #089DDD; color: white;">HARGA BELI</th>
           <th class="col-border" style="background: #089DDD; color: white;">QTY</th>
           <th class="col-border" style="background: #089DDD; color: white;">JUMLAH SATUAN</th>
           <th class="col-border" style="background: #089DDD; color: white;">DISKON</th>
           <th class="col-border" style="background: #089DDD; color: white;">JUMLAH</th>
           </tr>
         </thead>
         <tbody>
             @foreach($mdquotation as $a)

           <tr>
               <td class="col-border" style="text-align: left" class="tds">{{ $a->mdpurchasequotationgoodsid }}</td>
               <td class="col-border" style="text-align: left" class="tds">{{ $a->mdpurchasequotationgoodsname }}</td>
               <td class="col-border" style="text-align: right" class="tds">{{ number_format($a->mdpurchasequotationbuyprice,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="col-border" style="text-align: right;" class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td class="col-border" style="text-align: right" class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td class="col-border" style="text-align: right" class="tds">{{ number_format($a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
               <td class="col-border" style="text-align: right;" class="tds">{{ number_format($a->mdpurchasequotationbuyprice * $a->mdpurchasequotationgoodsqty - $a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>

           </tr>

            @endforeach
            <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>

           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
               <td class="col-border"></td>
           </tr>
           <tr>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
               <td style="border-bottom: solid; border-width: 1px;" class="col-border"></td>
           </tr>



              </tbody>
          <tfoot>
             <tr>
                    <td colspan="5"></td>
                    <td style="text-align: left;"><span contenteditable>Total Item :</span></td>
                    <td style="text-align: left;">IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $totalitem }}</td>
                </tr>

                <tr>
                    <td colspan="5"></td>
                    <td style="text-align: left;">Sub Total :</td>
                    <td style="text-align: left;">IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($subtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                   
                    
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td style="text-align: left;"><span contenteditable>Discount :</span></td>
                    <td style="text-align: left;">IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($discount,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
                 <tr>
                    <td colspan="5"></td>
                    <td style="border-bottom: 4px solid black; text-align: left;"><span contenteditable>PPN 10% :</span></td>
                     <td style="text-align: left;border-bottom: 4px solid black;">IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($quotation[0]['mhpurchasequotationtaxtotal'],$decimals,$dec_point,$thousands_sep) }}</td>

                </tr>
                 <tr>
                    <td colspan="5"></td>
                    <td style="text-align: left;"><span contenteditable>Total :</span></td>
                    <td style="text-align: left;background: #f0f0f2; border-style: solid; border-width: 1px;">IDR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($quotation[0]['mhpurchasequotationgrandtotal'],$decimals,$dec_point,$thousands_sep)}}</td>
                </tr>
          </tfoot>
       </table>

    </div>
    <br>
    <br>
    <div class="footertos">
    <div class="signbelow">
    <table class="tables">
        <tr>
            <th style="background: #089DDD; color: white; width: 330">TERMS AND CONDITIONS</th>
        </tr>
        <tr>
        <td>
           {!! $config->msyspurchinvfootnote !!}
        </td>
        </tr>

    </table>
     <table class="tables">
        <tr>
            <td>
                <pre>Customer Acceptance(sign below)</pre><br><br><br>



            -------------------------------------<br>

            Print Name
            </td>
        </tr>
    </table>

   </div>
   </div>
 <center>
     <h3>If you have any question about this price quote, please contact</h3><br>
     <b>Thank You For Your Business!</b>
 </center>

 <div class="footer">
     <p style="font-family: helvetica; font-weight: bold;">Dicetak oleh: {{ Auth::user()->name }}</p>
     <p style="font-family: helvetica; font-weight: bold;">Tanggal Cektak: {{ $carbon }}</p>

 </div>
 <div class="footerpage">
 <script type="text/php">
         if ( isset($pdf) ) {
             $x = 510;
             $y = 815;

             $text = "            Halaman ke {PAGE_NUM}";
             $font = $fontMetrics->get_font("helvetica", "bold");
             $size = 8;
             $color = array(0,0,0);
             $word_space = 0.0;  //  default
             $char_space = 0.0;  //  default
             $angle = 0.0;   //  default
             $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
         }
        if ( isset($pdf) ) {
            $x = 510;
            $y = 830;

            $text = "                          dari {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
    </div>
</body>
</html>
