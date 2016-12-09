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
        .filter-status {
            font-size: 9px;
            display: block;
        }
        </style>
    </head>
    <body>
        <h5 class="text-center">{{ $company }}</h5>
        <h5 class="text-center">Laporan Buku Piutang</h5>
        <h5 class="text-center">Per {{ $end }}</h5>
        <br>
        <p class="filter-status">Supplier {{ $spl }}</p>
        <p class="filter-status">Cabang {{ $br }}</p>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi" style="width:100%">
            <thead>
                <tr>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>No Pembelian</th>
                    <th>Tgl Invoice</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Nilai Pembelian</th>
                    <th>Outstanding</th>
                    <th>Aging</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aps as $ap)
                <tr>
                    @if($ap['data'] == false)
                        <td>{{ $ap['mapcardsupplierid'] }}</td>
                        <td>{{ $ap['mapcardsuppliername'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        <td></td>
                        <td></td>
                        <td>{{ $ap->mapcardtransno }}</td>
                        <td>{{ $ap->mapcardtdate }}</td>
                        <td>{{ $ap->mapcardduedate }}</td>
                        <td>{{ number_format($ap->mapcardtotalinv,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ap->mapcardoutstanding,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ $ap->aging }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th colspan="5">TOTAL</th>
                    <th>{{ number_format($total_iv,$decimals,$dec_point,$thousands_sep) }}</th>
                    <th>{{ number_format($total_out,$decimals,$dec_point,$thousands_sep) }}</th>
                </tr>
            </thead>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
