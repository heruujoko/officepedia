<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <style>
            body {
                font-size: 11px;
            }
            .wrapper {
                width: 100%;
            }

            .table {
                width: 100%;
            }

            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #000;
            }
            #footer {
                width: 100%;
            }
            .footline > td {
                border-top: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <table class="wrapper">
            <tr>
                <td width="70%">{{ $config->msyscompname }}</td>
                <td colspan="2">Nota Penjualan</td>
            </tr>
            <tr>
                <td>{{ $config->msyscompaddress }}</td>
                <td>No Faktur</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td></td>
                <td>Tanggal Faktur</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td></td>
                <td>Tanggal Faktur</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td></td>
                <td>Jatuh Tempo</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td>Kepada Yth :</td>
                <td>Tanggal Order</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td>{{ $invoice->mhinvoicecustomername }} {{ $invoice->mhinvoicecustomerid }}</td>
                <td>User</td>
                <td>: {{ Auth::user()->id }} {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>Divisi</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>No PO</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td>No Performa</td>
                <td>: #181818181</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table">
                        <tr>
                            <td>Kode</td>
                            <td>Nama Produk</td>
                            <td>Jumlah Barang</td>
                            <td>Multi Satuan</td>
                            <td>Harga Jual</td>
                            <td>Subtotal</td>
                            <td>Diskon</td>
                            <td>Diskon Special</td>
                        </tr>
                        @foreach($details as $d)
                            <tr>
                                <td>{{ $d->mhinvoiceno }}</td>
                                <td>{{ $d->mdinvoicegoodsid }} - {{ $d->mdinvoicegoodsname }}</td>
                                <td>{{ $d->mdinvoicegoodsqty }}</td>
                                <td>{{ $d['qty_label'] }}</td>
                                <td>{{ number_format($d->mdinvoicegoodsprice,$decimals,$dec_point,$thousands_sep)}}</td>
                                <td>{{ number_format($d->mdinvoicegoodsgrossamount,$decimals,$dec_point,$thousands_sep)}}</td>
                                <td>{{ number_format($d->mdinvoicegoodsdiscount,$decimals,$dec_point,$thousands_sep)}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
        <table id="footer">
            <tr>
                <td width="33%">Cap dan tanda-tangan</td>
                <td>Jumlah 115 Unit</td>
                <td>500.000</td>
                <td>0</td>
            </tr>
            <tr>
                <td width="33%"></td>
                <td>Subtotal</td>
                <td>500.000</td>
                <td></td>
            </tr>
            <tr>
                <td width="33%"></td>
                <td>Discount(Sudah Termasuk Cash Disc.) 1.000 %</td>
                <td>0</td>
                <td></td>
            </tr>
            <tr>
                <td width="33%"></td>
                <td>Dasar Pengenaan Pajak</td>
                <td>0</td>
                <td></td>
            </tr>
            <tr>
                <td width="33%">(...................................................) (...................................................)</td>
                <td>PPn 10%</td>
                <td>0</td>
                <td></td>
            </tr>
            <tr>
                <td width="33%"> <span>Toko / Pembeli</span> <span style="margin-left: 130px">Otorisasi</span> </td>
                <td>TOTAL</td>
                <td>0</td>
                <td></td>
            </tr>
            <tr class="footline">
                <td colspan="2" width="50%">
                    BARANG TELAH DITERIMA DENGAN BAIK DAN CUKUP.
                    KLAIM SETELAH PENGIRIMAN MENINGGALKAN TEMPAT,
                    TIDAK DAPAT DILAYAN. TERIMA KASIH.
                </td>
                <td colspan="2">
                    BARANG TELAH DITERIMA DENGAN BAIK DAN CUKUP.
                    KLAIM SETELAH PENGIRIMAN MENINGGALKAN TEMPAT,
                    TIDAK DAPAT DILAYAN. TERIMA KASIH.
                </td>
            </tr>
        </table>
    </body>
</html>
