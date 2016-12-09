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
        <h5 class="text-center">Laporan Pembelian</h5>
        <h5 class="text-center">Periode {{ $start }} - {{ $end }}</h5>
        <br>
        <p class="filter-status">Cabang {{ $br }}</p>
        <p class="filter-status">Supplier {{ $spl }}</p>
        <p class="filter-status">Barang {{ $goods }}</p>
        <p class="filter-status">Gudang {{ $wh }}</p>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi" style="width:100%">
            <thead>
                <tr>
                    <th>Tgl Transaksi</th>
                    <th>No Pembelian</th>
                    <th>Pembelian Dari</th>
                    <th>Kode Barang</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Free Goods</th>
                    <th>Discount</th>
                    <th>Subtotal</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $pr)
                <tr>
                    @if($pr['data'] == 0)
                        <td>{{ $pr['mdpurchasedate'] }}</td>
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
                    @else
                        <td></td>
                        <td>{{ $pr->mhpurchaseno }}</td>
                        <td>{{ $pr->mdpurchasesuppliername }}</td>
                        <td>{{ $pr->mdpurchasegoodsid }}</td>
                        <td>{{ $pr->mdpurchasegoodsqty }}</td>
                        <td style="text-align:right">{{ number_format($pr->mdpurchasebuyprice,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td> - </td>
                        <td style="text-align:right">{{ number_format($pr->mdpurchasegoodsdiscount,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right">{{ number_format(($pr->mdpurchasegoodsgrossamount - $pr->mdpurchasegoodsdiscount ),$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right">{{ number_format($pr->mdpurchasetax,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="text-align:right">{{ number_format(($pr->mdpurchasegoodsgrossamount - $pr->mdpurchasetax ),$decimals,$dec_point,$thousands_sep) }}</td>
                        <td></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>
