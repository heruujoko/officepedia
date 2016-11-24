<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sales</title>
        <style>
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
        </style>
    </head>
    <body>
        <h5 class="text-center">{{ $company }}</h5>
        <h5 class="text-center">Laporan Buku Penjualan</h5>
        <h5 class="text-center">Periode {{ $start }} - {{ $end }}</h5>
        <br>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Tgl Invoice</th>
                    <th>Jumlah Invoice</th>
                    <th>Penjualan</th>
                    <th>Bonus Barang</th>
                    <th>Discount</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Retur</th>
                    <th>Total - Retur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->mhinvoicecustomername }}</td>
                        <td>{{ $sale->mhinvoicedate }}</td>
                        <td>{{ $sale->detail_count }}</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicesubtotal + $sale->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right" v-priceformatlabel="num_format">0</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicesubtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicetaxtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicegrandtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right">0</td>
                        <td style="text-align:right" v-priceformatlabel="num_format" >{{ number_format($sale->mhinvoicegrandtotal,$decimals,$dec_point,$thousands_sep) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
