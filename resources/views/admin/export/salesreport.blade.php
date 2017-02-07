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
        .bold {
            font-weight: bold;
            font-size: 11px;
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
                    <td class="bold" width="10%">Tgl Transaksi</td>
                    <td class="bold">Kode Customer</td>
                    <td class="bold">Customer</td>
                    <td class="bold">Jumlah Invoice</td>
                    <td class="bold">No Invoice</td>
                    <td class="bold">Kode Barang</td>
                    <td class="bold">Nama Barang</td>
                    <td class="bold">Quantity</td>
                    <td class="bold">Harga Satuan</td>
                    <td class="bold">Free Goods</td>
                    <td class="bold">Discount</td>
                    <td class="bold">Subtotal</td>
                    <td class="bold">PPN</td>
                    <td class="bold">Total</td>
                    <td class="bold">Keterangan</td>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        @if($sale->header == true)
                            <td>{{ $sale->mhinvoicedate }}</td>
                        @else
                            <td></td>
                        @endif
                        @if($sale->header == false)
                            <td>{{ $sale->mhinvoicecustomerid }}</td>
                            <td>{{ $sale->mhinvoicecustomername }}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{ $sale->numoftrans }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <td colspan="2">TOTAL</td>
                </tr>
            </thead>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
