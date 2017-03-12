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
        <h5 class="text-center">Laporan History HPP</h5>
        <h5 class="text-center">Per {{ $end }}</h5>
        <br>
        <p class="filter-status">Barang {{ $goods }}</p>
        <p class="header-status">User {{ Auth::user()->name }}</p>
        <p class="header-status">Tanggal Cetak {{ Carbon\Carbon::now() }}</p>
        </div>
        <br>
        <table class="table" id="tableapi" style="width:100%">
            <thead>
                <tr>
                    <td style="font-weight:bold">Kode Barang</td>
                    <td style="font-weight:bold">Nama Barang</td>
                    <td style="font-weight:bold">Tanggal</td>
                    <td style="font-weight:bold">Qty</td>
                    <td style="font-weight:bold">Harga Beli</td>
                    <td style="font-weight:bold">Pembelian</td>
                    <td style="font-weight:bold">HPP</td>
                    <td style="font-weight:bold">Remark</td>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $h)
                    @if($h['data'] == 'header')
                    <tr>
                        <td>{{ $h['hpphistorygoodsid'] }}</td>
                        <td>{{ $h['name'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @elseif($h['data'] == 'data')
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $h->created_at }}</td>
                        <td>{{ $h->usage }}</td>
                        <td>{{ number_format($h->buyprice,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($h->hpphistorypurchase,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ number_format($h->hpphistorycogs,$decimals,$dec_point,$thousands_sep) }}</td>
                        <td>{{ $h->hpphistoryremarks }}</td>
                    </tr>
                    @elseif($h['data'] == 'footer')
                    <tr>
                        <td style="font-weight:bold">TOTAL</td>
                        <td style="font-weight:bold"></td>
                        <td style="font-weight:bold"></td>
                        <td style="font-weight:bold">{{ $h['hpphistoryqty'] }}</td>
                        <td style="font-weight:bold"></td>
                        <td style="font-weight:bold"></td>
                        <td style="font-weight:bold">{{ number_format($h['hpphistorycogs'],$decimals,$dec_point,$thousands_sep) }}</td>
                        <td style="font-weight:bold"></td>
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
