<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sales</title>
        <style>
        table th {
            font-size: 11px;
            text-align: left;
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
        .tbl-footer {
            background-image: -webkit-linear-gradient(top,#f2f2f2 0,#fafafa 100%);
        }
        </style>
    </head>
    <body>
        <h5 class="text-center">{{ $company }}</h5>
        <h5 class="text-center">Jurnal</h5>
        <h5 class="text-center">Periode {{ $start}} - {{ $end }}</h5>
        <br>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        @foreach($ledgers as $l)
            <h6>Kode Perkiraan : {{ $l['mcoacode'] }}</h6>
            <h6>Nama : {{ $l['mcoacode'] }} {{ $l['mcoaname'] }}</h6>
            <table class="table" id="tableapi" style="width:100%">
                <thead>
                    <tr class="tbl-footer">
                        <th>Tanggal</th>
                        <th>Akun</th>
                        <th>Keterangan</th>
                        <th>Tipe Transaksi</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td colspan="3">Saldo Sebelumnya</td>
                        <td colspan="2" style="text-align: right">{{ $l['last_saldo'] }}</td>
                    </tr>
                    @foreach($l['transactions'] as $tr)
                        <tr>
                            <td>{{ $tr['mjournaldate'] }}</td>
                            <td>{{ $tr['mjournalcoa'] }} - {{ $tr['coaname'] }}</td>
                            <td></td>
                            <td>{{ $tr['mjournaltranstype'] }}</td>
                            <td style="text-align: right">{{ number_format($tr['mjournaldebit'],$decimals,$dec_point,$thousands_sep) }}</td>
                            <td style="text-align: right">{{ number_format($tr['mjournalcredit'],$decimals,$dec_point,$thousands_sep) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr class="tbl-footer">
                        <td colspan="4" style="text-align: center">Total</td>
                        <td style="text-align: right">{{ number_format($l['sum_d'],$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align: right">{{ number_format($l['sum_k'],$decimals,$dec_point,$thousands_sep) }}</td>
                    </tr>
                </thead>
            </table>
        @endforeach
        <script>
            window.print();
        </script>
    </body>
</html>
