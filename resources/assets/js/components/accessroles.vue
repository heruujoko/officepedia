<template>
    <div>
        <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
            <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
        </div>
        <br>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama</label>
                    <div class="col-md-10">
                        <input v-bind:disabled="!notview" type="text" class="form-control" v-model="role_name">
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <button class="btn btn-primary pull-right">Simpan</button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 40%">Nama Menu</th>
                            <th style="width: 5%; text-align:center;">Lihat</th>
                            <th style="width: 5%; text-align:center;">Buat</th>
                            <th style="width: 5%; text-align:center;">Ubah</th>
                            <th style="width: 5%; text-align:center;">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="5" class="row-menu">Setting Sistem</th>
                        </tr>
                        <tr>
                            <td>Setting sistem</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_config">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_config">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_config">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_config">
                            </td>

                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Akutansi</th>
                        </tr>
                        <tr>
                            <td>Akun</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_mcoa">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_mcoa">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_mcoa">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_mcoa">
                            </td>

                        </tr>
                        <tr>
                            <td>Jurnal Umum</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_generaljournal">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_generaljournal">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_generaljournal">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_generaljournal">
                            </td>

                        </tr>
                        <tr>
                            <td>Fixed Asset</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_fixedasset">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_fixedasset">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_fixedasset">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_fixedasset">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Kas Bank</th>
                        </tr>
                        <tr>
                            <td>Daftar Kas / Bank</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_cashbank">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_cashbank">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_cashbank">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_cashbank">
                            </td>
                        </tr>
                        <tr>
                            <td>Pemasukan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_cashbankincome">
                            </td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_cashbankoutcome">
                            </td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_cashbanktransfer">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Pembelian</th>
                        </tr>
                        <tr>
                            <td>Pembelian</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_purchase">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_purchase">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_purchase">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_purchase">
                            </td>
                        </tr>
                        <tr>
                            <td>Pembayaran Hutang Dagang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_payap">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_payap">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_payap">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_payap">
                            </td>
                        </tr>
                        <tr>
                            <td>Pemesanan / Purchase Order</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_purchaseorder">
                            </td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_supplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_supplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_supplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_supplier">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Supplier</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_categorysupplier">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Penjualan</th>
                        </tr>
                        <tr>
                            <td>Penjualan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_sales">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_sales">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_sales">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_sales">
                            </td>
                        </tr>
                        <tr>
                            <td>Penawaran Penjualan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_salesquotation">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_salesquotation">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_salesquotation">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_salesquotation">
                            </td>
                        </tr>
                        <tr>
                            <td>Pembayaran Piutang Dagang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_payar">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_payar">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_payar">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_payar">
                            </td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_customer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_customer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_customer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_customer">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Customer</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_categorycustomer">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Harga</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_categoryprice">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_categoryprice">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_categoryprice">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_categoryprice">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Inventory</th>
                        </tr>
                        <tr>
                            <td>Barang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_goods">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_goods">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_goods">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_goods">
                            </td>
                        </tr>
                        <tr>
                            <td>Satuan Barang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_units">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_units">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_units">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_units">
                            </td>
                        </tr>
                        <tr>
                            <td>Merek Barang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_brands">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_brands">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_brands">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_brands">
                            </td>
                        </tr>
                        <tr>
                            <td>Tipe Barang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_goodstype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_goodstype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_goodstype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_goodstype">
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Tipe Barang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_goodssubtype">
                            </td>
                        </tr>
                        <tr>
                            <td>Gudang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_warehouse">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_warehouse">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_warehouse">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_warehouse">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Lain - lain</th>
                        </tr>
                        <tr>
                            <td>Karyawan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_employee">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_employee">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_employee">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_employee">
                            </td>
                        </tr>
                        <tr>
                            <td>Level Karyawan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_employeelevel">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_employeelevel">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_employeelevel">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_employeelevel">
                            </td>
                        </tr>
                        <tr>
                            <td>Mata Uang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_currency">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_currency">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_currency">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_currency">
                            </td>
                        </tr>
                        <tr>
                            <td>Pajak</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_tax">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_tax">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_tax">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_tax">
                            </td>
                        </tr>
                        <tr>
                            <td>Penggajian Karyawan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_employeepayment">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_employeepayment">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_employeepayment">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_employeepayment">
                            </td>
                        </tr>
                        <tr>
                            <td>Cabang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_branch">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_branch">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_branch">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_branch">
                            </td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_user">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.c_user">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.u_user">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.d_user">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Laporan</th>
                        </tr>
                        <tr>
                            <td>Laporan Stok</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_stockreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Penjualan</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_salesreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Penjualan Invoice</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_salesinvoicereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Piutang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_arreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Piutang Customer</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_arcustomerreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Pembelian</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_purchasereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Hutang</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_apreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan History HPP</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_stockvaluereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Jurnal</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_journal">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Buku Besar</td>
                            <td class="text-center">
                                <input type="checkbox" v-model="access_role.r_ledger">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['mode'],
        data(){
            return {
                role_name: "",
                access_role: {
                    c_config: true,
                    r_config: true,
                    u_config: true,
                    d_config: true,
                    c_mcoa: true,
                    r_mcoa: true,
                    u_mcoa: true,
                    d_mcoa: true,
                    c_generaljournal: true,
                    r_generaljournal: true,
                    u_generaljournal: true,
                    d_generaljournal: true,
                    c_fixedasset: true,
                    r_fixedasset: true,
                    u_fixedasset: true,
                    d_fixedasset: true,
                    c_cashbank: true,
                    r_cashbank: true,
                    u_cashbank: true,
                    d_cashbank: true,
                    c_cashbankincome: true,
                    r_cashbankincome: true,
                    u_cashbankincome: true,
                    d_cashbankincome: true,
                    c_cashbankoutcome: true,
                    r_cashbankoutcome: true,
                    u_cashbankoutcome: true,
                    d_cashbankoutcome: true,
                    c_cashbanktransfer: true,
                    r_cashbanktransfer: true,
                    u_cashbanktransfer: true,
                    d_cashbanktransfer: true,
                    c_purchase: true,
                    r_purchase: true,
                    u_purchase: true,
                    d_purchase: true,
                    c_payap: true,
                    r_payap: true,
                    u_payap: true,
                    d_payap: true,
                    c_purchaseorder: true,
                    r_purchaseorder: true,
                    u_purchaseorder: true,
                    d_purchaseorder: true,
                    c_supplier: true,
                    r_supplier: true,
                    u_supplier: true,
                    d_supplier: true,
                    c_categorysupplier: true,
                    r_categorysupplier: true,
                    u_categorysupplier: true,
                    d_categorysupplier: true,
                    c_sales: true,
                    r_sales: true,
                    u_sales: true,
                    d_sales: true,
                    c_salesquotation: true,
                    r_salesquotation: true,
                    u_salesquotation: true,
                    d_salesquotation: true,
                    c_payar: true,
                    r_payar: true,
                    u_payar: true,
                    d_payar: true,
                    c_customer: true,
                    r_customer: true,
                    u_customer: true,
                    d_customer: true,
                    c_categorycustomer: true,
                    r_categorycustomer: true,
                    u_categorycustomer: true,
                    d_categorycustomer: true,
                    c_categoryprice: true,
                    r_categoryprice: true,
                    u_categoryprice: true,
                    d_categoryprice: true,
                    c_goods: true,
                    r_goods: true,
                    u_goods: true,
                    d_goods: true,
                    c_units: true,
                    r_units: true,
                    u_units: true,
                    d_units: true,
                    c_brands: true,
                    r_brands: true,
                    u_brands: true,
                    d_brands: true,
                    c_goodstype: true,
                    r_goodstype: true,
                    u_goodstype: true,
                    d_goodstype: true,
                    c_goodssubtype: true,
                    r_goodssubtype: true,
                    u_goodssubtype: true,
                    d_goodssubtype: true,
                    c_warehouse: true,
                    r_warehouse: true,
                    u_warehouse: true,
                    d_warehouse: true,
                    c_employee: true,
                    r_employee: true,
                    u_employee: true,
                    d_employee: true,
                    c_employeelevel: true,
                    r_employeelevel: true,
                    u_employeelevel: true,
                    d_employeelevel: true,
                    c_currency: true,
                    r_currency: true,
                    u_currency: true,
                    d_currency: true,
                    c_tax: true,
                    r_tax: true,
                    u_tax: true,
                    d_tax: true,
                    c_employeepayment: true,
                    r_employeepayment: true,
                    u_employeepayment: true,
                    d_employeepayment: true,
                    c_branch: true,
                    r_branch: true,
                    u_branch: true,
                    d_branch: true,
                    c_user: true,
                    r_user: true,
                    u_user: true,
                    d_user: true,
                    r_stockreport: true,
                    r_salesreport: true,
                    r_salesinvoicereport: true,
                    r_arreport: true,
                    r_arcustomerreport: true,
                    r_purchasereport: true,
                    r_apreport: true,
                    r_stockvaluereport: true,
                    r_journal: true,
                    r_ledger: true
                }
            }
        },
        computed: {
            notview(){
                return this.mode != "view"
            }
        },
        methods: {
            toInsertMode(){}
        }

    }
</script>
