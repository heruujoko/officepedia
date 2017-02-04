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
        .table>tfoot tr:last-child {


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

    width: 350;
    border: 2px solid black;
    padding: 5px;

    }
    .footertos{
       padding-top: -120px;
    }
    .tdborder{
      border: 1px solid black;
    }

</style>
</head>
<body class="global-css">
<div class="top-left">
    {{-- TOP LEFT --}}
 	<h3 style="color: #257293">{{ $config->msyscompname }}</h3>
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
     <h3 style="padding-top: 25px;" style="color: #217293">Pesanan Pembelian</h3>
    <table border="" cellpadding="5" cellpadding="5">
        <tr>
            <th style=""></th>
        </tr>

        <tr>
            <th style="text-align: left;" class="thnoborder">DATE : </td>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationdate'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">QUOTE : </td>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationno'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">CUSTOMER ID :</td>
            <td style="border-style: solid; border-width: 1px; width: 85px; text-align: center;">{{ $quotation[0]['mhpurchasequotationsupplierid'] }}</td>
        </tr>
        <tr>
            <th style="text-align: left;" class="thnoborder">VALID UNTIL : </td>
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
               <td style="text-align: left" class="tds">{{ $a->mdpurchasequotationgoodsid }}</td>
               <td style="text-align: left" class="tds">{{ $a->mdpurchasequotationgoodsname }}</td>
               <td style="text-align: right" class="tds">{{ number_format($a->mdpurchasequotationbuyprice,$decimals,$dec_point,$thousands_sep) }}</td>
               <td style="text-align: right;" class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td style="text-align: right" class="tds">{{ $a->mdpurchasequotationgoodsqty }}</td>
               <td style="text-align: right" class="tds">{{ number_format($a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
               <td style="text-align: right;" class="tds">{{ number_format($a->mdpurchasequotationbuyprice * $a->mdpurchasequotationgoodsqty - $a->mdpurchasequotationgoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>

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



              </tbody>
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
                    <td style="background: #f0f0f2; border-style: solid; border-width: 1px;"><span data-prefix>IDR </span><span>{{ number_format($quotation[0]['mhpurchasequotationgrandtotal'],$decimals,$dec_point,$thousands_sep)}}</span></td>
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
            <th style="background: #089DDD; color: white; width: 350">TERMS AND CONDITIONS</th>
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
     <p>Dicetak oleh: {{ Auth::user()->name }}</p>
     <p>Tanggal Cektak: {{ $carbon }}</p>

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
