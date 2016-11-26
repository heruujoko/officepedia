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
        <h5 class="text-center">Laporan Buku Penjualan</h5>
        <h5 class="text-center">Periode {{ $start }} - {{ $end }}</h5>
        <br>
        <p class="filter-status">Gudang {{ $wh }}</p>
        <p class="filter-status">Barang {{ $goods }}</p>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>QTY Stock</th>
                    <th>Multi Satuan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Saldo</th>
                    <th>Tgl Trans</th>
                    <th>Tipe Transaksi</th>
                    <th>No Transaksi</th>
                    <th>Gudang</th>
                    <th>Cabang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $st)
                    <tr>
                        <td>{{ $st->mstockcardgoodsid }}</td>
                        <td>{{ $st->mstockcardgoodsname }}</td>
                        <td>{{ $st->goods()->mgoodsstock }}</td>
                        <td>{{ $st->saved_unit }}</td>
                        <td>{{ $st->mstockcardstockin }}</td>
                        <td>{{ $st->mstockcardstockout }}</td>
                        <td>{{ $st->mdinvoicegoodsgrossamount }}</td>
                        <td>{{ $st->mstockcarddate }}</td>
                        <td>{{ $st->mstockcardtranstype }}</td>
                        <td>{{ $st->mstockcardtransno }}</td>
                        <td>{{ $st->gudang()->mwarehousename }}</td>
                        <td> Umum </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
