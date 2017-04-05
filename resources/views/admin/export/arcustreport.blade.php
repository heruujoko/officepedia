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
        .bold{
            font-weight: bold;
            font-size: 12px;
        }
        </style>
    </head>
    <body>
        <h5 class="text-center">{{ $company }}</h5>
        <h5 class="text-center">Laporan Buku Piutang</h5>
        <h5 class="text-center">Per {{ $end }}</h5>
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
                    <td class="bold">Kode Customer</td>
                    <td class="bold">Nama Customer</td>
                    <td class="bold">Total Nota</td>
                    <td class="bold">No Invoice</td>
                    <td class="bold">Nilai Invoice</td>
                    <td class="bold">Outstanding</td>
                    <td class="bold">Tgl Invoice</td>
                    <td class="bold">Tgl Jatuh Tempo</td>
                    <td class="bold">Aging</td>
                    <td class="bold">Jatuh Tempo</td>
                    <td class="bold">1 - 7 Hari</td>
                    <td class="bold">7 - 14 Hari</td>
                    <td class="bold">14 - 21 Hari</td>
                    <td class="bold">21 - 30 Hari</td>
                    <td class="bold">> 1 Bulan</td>
                </tr>
            </thead>
            <tbody>
                @foreach($ars as $ar)
                    @if($ar->header == true)
                        <tr>
                            <td>{{ $ar->marcardcustomerid }}</td>
                            <td>{{ $ar->marcardcustomername }}</td>
                            <td>{{ $ar->numoftrans }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($ar->{'1w'},$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($ar->{'2w'},$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($ar->{'3w'},$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($ar->{'4w'},$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($ar->{'1m'},$decimals,$dec_point,$thousands_sep) }}</td>
                        </tr>
                    @elseif($ar->data == true)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $ar->marcardtransno }}</td>
                        <td>{{ number_format($ar->marcardtotalinv,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ar->marcardoutstanding,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ $ar->marcarddate }}</td>
                        <td>{{ $ar->marcardduedate }}</td>
                        <td>{{ $ar->aging }}</td>
                        <td>{{ $ar->has_due }}</td>
                        <td>{{ number_format($ar->{'1w'},$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ar->{'2w'},$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ar->{'3w'},$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ar->{'4w'},$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($ar->{'1m'},$decimals,$dec_point,$thousands_sep) }}</td>
                    </tr>
                    @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($total_inv,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td>{{ number_format($total_outs,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($total_1w,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td>{{ number_format($total_2w,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td>{{ number_format($total_3w,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td>{{ number_format($total_4w,$decimals,$dec_point,$thousands_sep) }}</td>
                    <td>{{ number_format($total_1m,$decimals,$dec_point,$thousands_sep) }}</td>
                </tr>
            </thead>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
