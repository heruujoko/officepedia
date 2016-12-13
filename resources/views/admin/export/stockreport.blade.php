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
            width: 100%;
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
                    @if($st['data'] == 'header')
                    <tr>
                        <td>{{ $st['mstockcardgoodsid'] }}</td>
                        <td>{{ $st['mstockcardgoodsname'] }}</td>
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
                    @elseif($st['data'] == 'data')
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $st->mstockcardstocktotal }}</td>
                        <td>{{ $st['verbs'] }}</td>
                        <td>{{ $st->mstockcardstockin }}</td>
                        <td>{{ $st->mstockcardstockout }}</td>
                        <td>{{ ($st->mstockcardstocktotal +$st->mstockcardstockin - $st->mstockcardstockout) }}</td>
                        <td>{{ $st->mstockcarddate }}</td>
                        <td>{{ $st->mstockcardtranstype }}</td>
                        <td>{{ $st->mstockcardtransno }}</td>
                        <td>{{ $st['gudang'] }}</td>
                        <td> Umum </td>
                        <td></td>
                    </tr>
                    @elseif($st['data'] == 'footer')
                    <tr>
                        <th>Saldo</th>
                        <th></th>
                        <th>{{ $st['mstockcardstocktotal'] }}</th>
                        <th>{{ $st['verbs'] }}</th>
                        <th>{{ $st['mstockcardstockin'] }}</th>
                        <th>{{ $st['mstockcardstockout'] }}</th>
                        <th>{{ ($st['mstockcardstocktotal'] +$st['mstockcardstockin'] - $st['mstockcardstockout']) }}</th>
                        <th>{{ $st['mstockcarddate'] }}</th>
                        <th>{{ $st['mstockcardtranstype'] }}</th>
                        <th>{{ $st['mstockcardtransno'] }}</th>
                        <th>{{ $st['gudang'] }}</th>
                        <th> Umum </th>
                        <th></th>
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
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
