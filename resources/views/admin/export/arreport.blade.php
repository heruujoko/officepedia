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
        <h5 class="text-center">Periode {{ $start }} - {{ $end }}</h5>
        <br>
        <p class="filter-status">Cabang {{ $br }}</p>
        <p class="filter-status">Customer {{ $cust }}</p>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi" style="width:100%">
            <thead>
                <tr>
                    <th colspan="4">&nbsp;</th>
                    <th colspan="5" class="text-center">Outstanding</th>
                </tr>
                <tr>
                    <th>Kode Customer</th>
                    <th>Nama Customer</th>
                    <th>Total Nota</th>
                    <th>Outstanding</th>
                    <th>1-7 Hari</th>
                    <th>7-14 Hari</th>
                    <th>14-21 Hari</th>
                    <th>21-30 Hari</th>
                    <th>> 1 Bulan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ars as $ar)
                <tr >
                    <td>{{ $ar->marcardcustomerid }}</td>
                    <td>{{ $ar->marcardcustomername }}</td>
                    <td style="text-align:right">{{ number_format($ar->marcardtotalinv,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->marcardtotalinv,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->seven,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->fourteen,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->twentyone,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->thirty,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td style="text-align:right">{{ number_format($ar->month,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
