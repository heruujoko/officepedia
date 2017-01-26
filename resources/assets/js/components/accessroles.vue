<template>
    <div>
        <br>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama</label>
                    <div class="col-md-10">
                        <input v-bind:disabled="!notview" type="text" class="form-control" v-model="access_role.name">
                        <label style="color:rgb(212, 103, 82)!important" v-if="name_alert">Nama tidak boleh kosong</label>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <button v-show="mode == 'insert'" class="btn btn-primary pull-right" v-on:click="saveRole">Simpan</button>
                    <button v-show="mode == 'edit'" class="btn btn-primary pull-right" v-on:click="updateRole">Update</button>
                    <button v-show="mode != 'insert'" v-on:click="toInsertMode" class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
                </div>
            </div>
        </div>
        <br>
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
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_config">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_config">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_config">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_config">
                            </td>

                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Akutansi</th>
                        </tr>
                        <tr>
                            <td>Akun</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_mcoa">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_mcoa">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_mcoa">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_mcoa">
                            </td>

                        </tr>
                        <tr>
                            <td>Jurnal Umum</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_generaljournal">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_generaljournal">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_generaljournal">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_generaljournal">
                            </td>

                        </tr>
                        <tr>
                            <td>Fixed Asset</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_fixedasset">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_fixedasset">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_fixedasset">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_fixedasset">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Kas Bank</th>
                        </tr>
                        <tr>
                            <td>Daftar Kas / Bank</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_cashbank">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_cashbank">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_cashbank">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_cashbank">
                            </td>
                        </tr>
                        <tr>
                            <td>Pemasukan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_cashbankincome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_cashbankincome">
                            </td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_cashbankoutcome">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_cashbankoutcome">
                            </td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_cashbanktransfer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_cashbanktransfer">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Pembelian</th>
                        </tr>
                        <tr>
                            <td>Pembelian</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_purchase">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_purchase">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_purchase">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_purchase">
                            </td>
                        </tr>
                        <tr>
                            <td>Pembayaran Hutang Dagang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_payap">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_payap">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_payap">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_payap">
                            </td>
                        </tr>
                        <tr>
                            <td>Pemesanan / Purchase Order</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_purchaseorder">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_purchaseorder">
                            </td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_supplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_supplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_supplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_supplier">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Supplier</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_categorysupplier">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_categorysupplier">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Penjualan</th>
                        </tr>
                        <tr>
                            <td>Penjualan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_sales">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_sales">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_sales">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_sales">
                            </td>
                        </tr>
                        <tr>
                            <td>Penawaran Penjualan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_salesquotation">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_salesquotation">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_salesquotation">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_salesquotation">
                            </td>
                        </tr>
                        <tr>
                            <td>Pembayaran Piutang Dagang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_payar">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_payar">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_payar">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_payar">
                            </td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_customer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_customer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_customer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_customer">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Customer</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_categorycustomer">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_categorycustomer">
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori Harga</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_categoryprice">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_categoryprice">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_categoryprice">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_categoryprice">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Inventory</th>
                        </tr>
                        <tr>
                            <td>Barang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_goods">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_goods">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_goods">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_goods">
                            </td>
                        </tr>
                        <tr>
                            <td>Satuan Barang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_units">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_units">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_units">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_units">
                            </td>
                        </tr>
                        <tr>
                            <td>Merek Barang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_brands">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_brands">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_brands">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_brands">
                            </td>
                        </tr>
                        <tr>
                            <td>Tipe Barang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_goodstype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_goodstype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_goodstype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_goodstype">
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Tipe Barang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_goodssubtype">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_goodssubtype">
                            </td>
                        </tr>
                        <tr>
                            <td>Gudang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_warehouse">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_warehouse">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_warehouse">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_warehouse">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Lain - lain</th>
                        </tr>
                        <tr>
                            <td>Karyawan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_employee">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_employee">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_employee">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_employee">
                            </td>
                        </tr>
                        <tr>
                            <td>Level Karyawan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_employeelevel">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_employeelevel">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_employeelevel">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_employeelevel">
                            </td>
                        </tr>
                        <tr>
                            <td>Mata Uang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_currency">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_currency">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_currency">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_currency">
                            </td>
                        </tr>
                        <tr>
                            <td>Pajak</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_tax">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_tax">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_tax">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_tax">
                            </td>
                        </tr>
                        <tr>
                            <td>Penggajian Karyawan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_employeepayment">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_employeepayment">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_employeepayment">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_employeepayment">
                            </td>
                        </tr>
                        <tr>
                            <td>Cabang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_branch">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_branch">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_branch">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_branch">
                            </td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_user">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.c_user">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.u_user">
                            </td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.d_user">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" class="row-menu">Laporan</th>
                        </tr>
                        <tr>
                            <td>Laporan Stok</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_stockreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Penjualan</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_salesreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Penjualan Invoice</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_salesinvoicereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Piutang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_arreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Piutang Customer</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_arcustomerreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Pembelian</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_purchasereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan Hutang</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_apreport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Laporan History HPP</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_stockvaluereport">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Jurnal</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_journal">
                            </td>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td>Buku Besar</td>
                            <td class="text-center">
                                <input v-bind:disabled="!notview" type="checkbox" v-model="access_role.r_ledger">
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
    import Axios from 'Axios'
    import swal from 'sweetalert'
    export default {
        props: ['mode'],
        data(){
            return {
                name_alert: false,
                editid: 0,
                access_role: {
                    name: "",
                    c_config: false,
                    r_config: false,
                    u_config: false,
                    d_config: false,
                    c_mcoa: false,
                    r_mcoa: false,
                    u_mcoa: false,
                    d_mcoa: false,
                    c_generaljournal: false,
                    r_generaljournal: false,
                    u_generaljournal: false,
                    d_generaljournal: false,
                    c_fixedasset: false,
                    r_fixedasset: false,
                    u_fixedasset: false,
                    d_fixedasset: false,
                    c_cashbank: false,
                    r_cashbank: false,
                    u_cashbank: false,
                    d_cashbank: false,
                    c_cashbankincome: false,
                    r_cashbankincome: false,
                    u_cashbankincome: false,
                    d_cashbankincome: false,
                    c_cashbankoutcome: false,
                    r_cashbankoutcome: false,
                    u_cashbankoutcome: false,
                    d_cashbankoutcome: false,
                    c_cashbanktransfer: false,
                    r_cashbanktransfer: false,
                    u_cashbanktransfer: false,
                    d_cashbanktransfer: false,
                    c_purchase: false,
                    r_purchase: false,
                    u_purchase: false,
                    d_purchase: false,
                    c_payap: false,
                    r_payap: false,
                    u_payap: false,
                    d_payap: false,
                    c_purchaseorder: false,
                    r_purchaseorder: false,
                    u_purchaseorder: false,
                    d_purchaseorder: false,
                    c_supplier: false,
                    r_supplier: false,
                    u_supplier: false,
                    d_supplier: false,
                    c_categorysupplier: false,
                    r_categorysupplier: false,
                    u_categorysupplier: false,
                    d_categorysupplier: false,
                    c_sales: false,
                    r_sales: false,
                    u_sales: false,
                    d_sales: false,
                    c_salesquotation: false,
                    r_salesquotation: false,
                    u_salesquotation: false,
                    d_salesquotation: false,
                    c_payar: false,
                    r_payar: false,
                    u_payar: false,
                    d_payar: false,
                    c_customer: false,
                    r_customer: false,
                    u_customer: false,
                    d_customer: false,
                    c_categorycustomer: false,
                    r_categorycustomer: false,
                    u_categorycustomer: false,
                    d_categorycustomer: false,
                    c_categoryprice: false,
                    r_categoryprice: false,
                    u_categoryprice: false,
                    d_categoryprice: false,
                    c_goods: false,
                    r_goods: false,
                    u_goods: false,
                    d_goods: false,
                    c_units: false,
                    r_units: false,
                    u_units: false,
                    d_units: false,
                    c_brands: false,
                    r_brands: false,
                    u_brands: false,
                    d_brands: false,
                    c_goodstype: false,
                    r_goodstype: false,
                    u_goodstype: false,
                    d_goodstype: false,
                    c_goodssubtype: false,
                    r_goodssubtype: false,
                    u_goodssubtype: false,
                    d_goodssubtype: false,
                    c_warehouse: false,
                    r_warehouse: false,
                    u_warehouse: false,
                    d_warehouse: false,
                    c_employee: false,
                    r_employee: false,
                    u_employee: false,
                    d_employee: false,
                    c_employeelevel: false,
                    r_employeelevel: false,
                    u_employeelevel: false,
                    d_employeelevel: false,
                    c_currency: false,
                    r_currency: false,
                    u_currency: false,
                    d_currency: false,
                    c_tax: false,
                    r_tax: false,
                    u_tax: false,
                    d_tax: false,
                    c_employeepayment: false,
                    r_employeepayment: false,
                    u_employeepayment: false,
                    d_employeepayment: false,
                    c_branch: false,
                    r_branch: false,
                    u_branch: false,
                    d_branch: false,
                    c_user: false,
                    r_user: false,
                    u_user: false,
                    d_user: false,
                    r_stockreport: false,
                    r_salesreport: false,
                    r_salesinvoicereport: false,
                    r_arreport: false,
                    r_arcustomerreport: false,
                    r_purchasereport: false,
                    r_apreport: false,
                    r_stockvaluereport: false,
                    r_journal: false,
                    r_ledger: false
                }
            }
        },
        computed: {
            notview(){
                return this.mode != "view"
            }
        },
        methods: {
            toInsertMode(){
                this.resetForm();
                $('#forminput').show();
        		$('#formview').hide();
        		$('#formedit').hide();
        		window.location.href="#forminput";
            },
            resetForm(){
                this.name_alert = false
                this.editid = 0
                this.access_role = {
                    name: "",
                    c_config: false,
                    r_config: false,
                    u_config: false,
                    d_config: false,
                    c_mcoa: false,
                    r_mcoa: false,
                    u_mcoa: false,
                    d_mcoa: false,
                    c_generaljournal: false,
                    r_generaljournal: false,
                    u_generaljournal: false,
                    d_generaljournal: false,
                    c_fixedasset: false,
                    r_fixedasset: false,
                    u_fixedasset: false,
                    d_fixedasset: false,
                    c_cashbank: false,
                    r_cashbank: false,
                    u_cashbank: false,
                    d_cashbank: false,
                    c_cashbankincome: false,
                    r_cashbankincome: false,
                    u_cashbankincome: false,
                    d_cashbankincome: false,
                    c_cashbankoutcome: false,
                    r_cashbankoutcome: false,
                    u_cashbankoutcome: false,
                    d_cashbankoutcome: false,
                    c_cashbanktransfer: false,
                    r_cashbanktransfer: false,
                    u_cashbanktransfer: false,
                    d_cashbanktransfer: false,
                    c_purchase: false,
                    r_purchase: false,
                    u_purchase: false,
                    d_purchase: false,
                    c_payap: false,
                    r_payap: false,
                    u_payap: false,
                    d_payap: false,
                    c_purchaseorder: false,
                    r_purchaseorder: false,
                    u_purchaseorder: false,
                    d_purchaseorder: false,
                    c_supplier: false,
                    r_supplier: false,
                    u_supplier: false,
                    d_supplier: false,
                    c_categorysupplier: false,
                    r_categorysupplier: false,
                    u_categorysupplier: false,
                    d_categorysupplier: false,
                    c_sales: false,
                    r_sales: false,
                    u_sales: false,
                    d_sales: false,
                    c_salesquotation: false,
                    r_salesquotation: false,
                    u_salesquotation: false,
                    d_salesquotation: false,
                    c_payar: false,
                    r_payar: false,
                    u_payar: false,
                    d_payar: false,
                    c_customer: false,
                    r_customer: false,
                    u_customer: false,
                    d_customer: false,
                    c_categorycustomer: false,
                    r_categorycustomer: false,
                    u_categorycustomer: false,
                    d_categorycustomer: false,
                    c_categoryprice: false,
                    r_categoryprice: false,
                    u_categoryprice: false,
                    d_categoryprice: false,
                    c_goods: false,
                    r_goods: false,
                    u_goods: false,
                    d_goods: false,
                    c_units: false,
                    r_units: false,
                    u_units: false,
                    d_units: false,
                    c_brands: false,
                    r_brands: false,
                    u_brands: false,
                    d_brands: false,
                    c_goodstype: false,
                    r_goodstype: false,
                    u_goodstype: false,
                    d_goodstype: false,
                    c_goodssubtype: false,
                    r_goodssubtype: false,
                    u_goodssubtype: false,
                    d_goodssubtype: false,
                    c_warehouse: false,
                    r_warehouse: false,
                    u_warehouse: false,
                    d_warehouse: false,
                    c_employee: false,
                    r_employee: false,
                    u_employee: false,
                    d_employee: false,
                    c_employeelevel: false,
                    r_employeelevel: false,
                    u_employeelevel: false,
                    d_employeelevel: false,
                    c_currency: false,
                    r_currency: false,
                    u_currency: false,
                    d_currency: false,
                    c_tax: false,
                    r_tax: false,
                    u_tax: false,
                    d_tax: false,
                    c_employeepayment: false,
                    r_employeepayment: false,
                    u_employeepayment: false,
                    d_employeepayment: false,
                    c_branch: false,
                    r_branch: false,
                    u_branch: false,
                    d_branch: false,
                    c_user: false,
                    r_user: false,
                    u_user: false,
                    d_user: false,
                    r_stockreport: false,
                    r_salesreport: false,
                    r_salesinvoicereport: false,
                    r_arreport: false,
                    r_arcustomerreport: false,
                    r_purchasereport: false,
                    r_apreport: false,
                    r_stockvaluereport: false,
                    r_journal: false,
                    r_ledger: false
                };
            },
            saveRole(){
                if(this.access_role.name == ""){
                    this.name_alert = true;
                } else {
                    Axios.post('/admin-api/roles',this.access_role)
                    .then( res => {
                        swal({
                          title: "Success!",
                          text: "Penambahan Berhasil",
                          type: "success",
                          timer: 1000
                        });
                        $('.tableapi').DataTable().ajax.reload();
                        this.toInsertMode();
                    })
                    .catch( err => {
                        swal({
                          title: "Oops!",
                          text: "Penambahan Gagal",
                          type: "error",
                          timer: 1000
                        });
                        this.toInsertMode();
                    });
                }
            },
            updateRole(){
                if(this.access_role.name == ""){
                    this.name_alert = true;
                } else {
                    Axios.put('/admin-api/roles/'+this.editid,this.access_role)
                    .then( res => {
                        swal({
                          title: "Success!",
                          text: "Pengubahan Berhasil",
                          type: "success",
                          timer: 1000
                        });
                        $('.tableapi').DataTable().ajax.reload();
                        this.toInsertMode();
                    })
                    .catch( err => {
                        swal({
                          title: "Oops!",
                          text: "Pengubahan Gagal",
                          type: "error",
                          timer: 1000
                        });
                        this.toInsertMode();
                    });
                }
            },
            fetchRole(id){
                Axios.get('/admin-api/roles/'+id)
                .then( res => {
                    // this.$set(this.access_role,res.data);
                    var keys = Object.keys(res.data);
                     var n = keys.length;
                     while (n--) {
                       var key = keys[n];
                       if (key !== key.toLowerCase()) {
                           res.data[key.toLowerCase()] = res.data[key]
                           delete res.data[key]
                       }
                    }
                    console.log(res.data);
                    this.access_role = res.data;
                })
                .catch( err => {
                    console.log(err);
                    swal({
                      title: "Oops!",
                      text: "Role tidak ditemukan",
                      type: "error",
                      timer: 1000
                    });
                })
            }
        },
        mounted(){
            if(this.mode == "edit"){
                this.$parent.$on('edit-selected',(roleid) => {
                  this.editid = roleid;
                  this.fetchRole(roleid);
                });
            }
            if(this.mode == "view"){
                this.$parent.$on('view-selected',(roleid) => {
                  this.editid = roleid;
                  this.fetchRole(roleid);
                });
            }
        }
    }
</script>
