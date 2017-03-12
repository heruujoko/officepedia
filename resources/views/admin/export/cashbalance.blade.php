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
        <h5 class="text-center">Jurnal</h5>
        <h5 class="text-center">Periode {{ $start }} - {{ $end }}</h5>
        <br>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <td style="font-weight: bold">No Akun</td>
                        <td style="font-weight: bold">Nama Akun</td>
                        <td style="font-weight: bold">Debet</td>
                        <td style="font-weight: bold">Credit</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($journals as $j)
                    @if($j['type'] == 'data')
                        <tr>
                            <td>{{ $j->mcoacode }}</td>
                            <td>{{ $j->mcoaname }}</td>
                            <td>{{ number_format($j['sum_debit'],$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($j['sum_credit'],$decimals,$dec_point,$thousands_sep) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2">TOTAL</td>
                            <td>{{ number_format($j['sum_debit'],$decimals,$dec_point,$thousands_sep) }}</td>
                            <td>{{ number_format($j['sum_credit'],$decimals,$dec_point,$thousands_sep) }}</td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            <br>
        <script>
            window.print();
        </script>
    </body>
</html>
