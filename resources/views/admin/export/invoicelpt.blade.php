<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <style type="text/css" media="print">
          @page { size: landscape; }
          table th {
              font-size: 11px;
          }
          table td {
              font-size: 8px;
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
          tbody {
              display: table-row-group;
              vertical-align: middle;
              border-color: inherit;
          }
          .lc {
            height: 30px;
          }
          .text-center {
              text-align: center;
          }
          .report-label {
              font-size: 14px;
              margin-top: 5px;
          }
          .header-status {
              font-size: 9px;
              text-align: right;
              display: block;
          }
          .filter-status {
              font-size: 9px;
              display: block;
          }
        </style>
        <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}" />
    </head>
    <body>
        <div class="row">
            <div class="col-md-6">
                <p>{{ $config->msyscompname }}</p>
                <p>{{ $config->msyscompaddress }}</p>
            </div>
            <div class="col-md-6">
                <h2 class="pull-right" style="margin-right: 50px">INVOICE</h2>
            </div>
        </div>
        <hr>
        <p>Kepada : {{ $invoice->mhinvoicecustomername }}</p>
        <p>Telpon : {{ $invoice->mhinvoicecustomername }}</p>
        <p>Alamat : {{ $invoice->mhinvoicecustomername }}</p>
        <table class="table" id="tableapi" style="width:100%">
            <thead>
                <tr>
                    <td style="font-weight: bold">Kode</td>
                    <td style="font-weight: bold">Nama Barang</td>
                    <td style="font-weight: bold">Satuan</td>
                    <td style="font-weight: bold">Harga Satuan</td>
                    <td style="font-weight: bold">Subtotal</td>
                    <td style="font-weight: bold">Discount</td>
                    <td style="font-weight: bold">Pajak</td>
                    <td style="font-weight: bold">Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $d)
                    <tr>
                        <td>{{ $d->mhinvoiceno }}</td>
                        <td>{{ $d->mdinvoicegoodsid }} - {{ $d->mdinvoicegoodsname }}</td>
                        <td>{{ $d['qty_label'] }}</td>
                        <td>{{ number_format($d->mdinvoicegoodsprice,$decimals,$dec_point,$thousands_sep)}}</td>
                        <td>{{ number_format($d->mdinvoicegoodsgrossamount,$decimals,$dec_point,$thousands_sep)}}</td>
                        <td>{{ number_format($d->mdinvoicegoodsdiscount,$decimals,$dec_point,$thousands_sep)}}</td>
                        <td>{{ number_format($d->mdinvoicegoodstax,$decimals,$dec_point,$thousands_sep)}}</td>
                        <td>{{ number_format(( $d->mdinvoicegoodsgrossamount + $d->mdinvoicegoodstax - $d->mdinvoicegoodsdiscount),$decimals,$dec_point,$thousands_sep)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" rowspan="4">Total Item : {{ count($details) }} item.</td>
                    <td colspan="3">Subtotal</td>
                    <td>{{ number_format($sum_subtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Diskon</td>
                    <td>{{ number_format($sum_disc,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Pajak</td>
                    <td>{{ number_format($sum_tax,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td>{{ number_format(( $sum_subtotal + $sum_tax - $sum_disc ),$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
            window.print();
        </script>
    </body>
</html>
