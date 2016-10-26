<?php

use Illuminate\Database\Seeder;

use App\MCOA;
use App\MCOAParent;
use App\MCOAGrandParent;

class MCOAFullSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

      // setup grand parent data
      MCOAGrandParent::create([
        'mcoagrandparentcode' => '1000.00',
        'mcoagrandparentname' => 'Harta',
        'mcoagrandparenttype' => 'D'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '2000.00',
        'mcoagrandparentname' => 'Kewajiban',
        'mcoagrandparenttype' => 'K'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '3000.00',
        'mcoagrandparentname' => 'Modal',
        'mcoagrandparenttype' => 'K'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '4000.00',
        'mcoagrandparentname' => 'Pendapatan',
        'mcoagrandparenttype' => 'K'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '5000.00',
        'mcoagrandparentname' => 'Biaya Atas Pendapatan',
        'mcoagrandparenttype' => 'D'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '6000.00',
        'mcoagrandparentname' => 'Pengeluaran Operasional',
        'mcoagrandparenttype' => 'D'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '7000.00',
        'mcoagrandparentname' => 'Pendapatan Luar Usaha',
        'mcoagrandparenttype' => 'K'
      ]);

      MCOAGrandParent::create([
        'mcoagrandparentcode' => '8000.00',
        'mcoagrandparentname' => 'Pengeluaran Luar Usaha',
        'mcoagrandparenttype' => 'D'
      ]);

      // setup parent and child data

      $harta = MCOAGrandParent::where('mcoagrandparentcode','1000.00')->first();

      MCOAParent::create([
        'mcoaparentcode' => '1101.00',
        'mcoaparentname' => 'Kas',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $kas = MCOAParent::where('mcoaparentcode','1101.00')->first();

        MCOA::create([
          'mcoacode' => '1101.01',
          'mcoaname' => 'Kas Kecil',
          'mcoaparentcode' => $kas->mcoaparentcode,
          'mcoaparentname' => $kas->mcoaparentname,
          'mcoatype' => $kas->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1101.02',
          'mcoaname' => 'Kas Besar',
          'mcoaparentcode' => $kas->mcoaparentcode,
          'mcoaparentname' => $kas->mcoaparentname,
          'mcoatype' => $kas->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1101.03',
          'mcoaname' => 'Open CBG',
          'mcoaparentcode' => $kas->mcoaparentcode,
          'mcoaparentname' => $kas->mcoaparentname,
          'mcoatype' => $kas->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1102.00',
        'mcoaparentname' => 'Bank',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $bank = MCOAParent::where('mcoaparentcode','1102.00')->first();

        MCOA::create([
          'mcoacode' => '1102.01',
          'mcoaname' => 'Bank (IDR)',
          'mcoaparentcode' => $bank->mcoaparentcode,
          'mcoaparentname' => $bank->mcoaparentname,
          'mcoatype' => $bank->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1102.02',
          'mcoaname' => 'Bank (USD)',
          'mcoaparentcode' => $bank->mcoaparentcode,
          'mcoaparentname' => $bank->mcoaparentname,
          'mcoatype' => $bank->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1102.03',
          'mcoaname' => 'Unreconciled Bank',
          'mcoaparentcode' => $bank->mcoaparentcode,
          'mcoaparentname' => $bank->mcoaparentname,
          'mcoatype' => $bank->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1103.00',
        'mcoaparentname' => 'Piutang Usaha',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $piutang_usaha = MCOAParent::where('mcoaparentcode','1103.00')->first();

        MCOA::create([
          'mcoacode' => '1103.01',
          'mcoaname' => 'Piutang Giro',
          'mcoaparentcode' => $piutang_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_usaha->mcoaparentname,
          'mcoatype' => $piutang_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1103.02',
          'mcoaname' => 'Piutang Usaha',
          'mcoaparentcode' => $piutang_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_usaha->mcoaparentname,
          'mcoatype' => $piutang_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1103.03',
          'mcoaname' => 'Piutang Usaha (USD)',
          'mcoaparentcode' => $piutang_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_usaha->mcoaparentname,
          'mcoatype' => $piutang_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1103.04',
          'mcoaname' => 'Deposit Supplier',
          'mcoaparentcode' => $piutang_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_usaha->mcoaparentname,
          'mcoatype' => $piutang_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1104.00',
        'mcoaparentname' => 'Piutang Non Usaha',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $piutang_non_usaha = MCOAParent::where('mcoaparentcode','1104.00')->first();

        MCOA::create([
          'mcoacode' => '1104.01',
          'mcoaname' => 'Unbilled Delivery',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1104.02',
          'mcoaname' => 'Unbilled Service/Fee',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1104.03',
          'mcoaname' => 'Unbilled Konsiyasi',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1104.04',
          'mcoaname' => 'Piutang Non Usaha',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1104.05',
          'mcoaname' => 'Cadangan Kerugian Piutang',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1104.06',
          'mcoaname' => 'Piutang Karyawan/KasBon',
          'mcoaparentcode' => $piutang_non_usaha->mcoaparentcode,
          'mcoaparentname' => $piutang_non_usaha->mcoaparentname,
          'mcoatype' => $piutang_non_usaha->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1105.00',
        'mcoaparentname' => 'Persediaan',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $persediaan = MCOAParent::where('mcoaparentcode','1105.00')->first();

        MCOA::create([
          'mcoacode' => '1105.01',
          'mcoaname' => 'Persediaan Barang Dagang',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1105.02',
          'mcoaname' => 'Persediaan Bahan Baku',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1105.03',
          'mcoaname' => 'Persediaan Barang Setengah Jadi',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1105.04',
          'mcoaname' => 'Persediaan Barang Dalam Proses',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1105.05',
          'mcoaname' => 'Persediaan Konsiyasi Keluar',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1105.06',
          'mcoaname' => 'Persediaan Perlengkapan Marketing Tool Kit',
          'mcoaparentcode' => $persediaan->mcoaparentcode,
          'mcoaparentname' => $persediaan->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1106.00',
        'mcoaparentname' => 'Uang Muka',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $uang_muka = MCOAParent::where('mcoaparentcode','1106.00')->first();

        MCOA::create([
          'mcoacode' => '1106.01',
          'mcoaname' => 'Uang Muka Pembelian Brg Dagang',
          'mcoaparentcode' => $uang_muka->mcoaparentcode,
          'mcoaparentname' => $uang_muka->mcoaparentname,
          'mcoatype' => $uang_muka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1106.02',
          'mcoaname' => 'Uang Muka Pembelian Kendaraan',
          'mcoaparentcode' => $uang_muka->mcoaparentcode,
          'mcoaparentname' => $uang_muka->mcoaparentname,
          'mcoatype' => $persediaan->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1107.00',
        'mcoaparentname' => 'Pajak Dibayar Dimuka',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $pajak_dibayar_dimuka = MCOAParent::where('mcoaparentcode','1107.00')->first();

        MCOA::create([
          'mcoacode' => '1107.01',
          'mcoaname' => 'Piutang Pajak Pembelian (PPn Masukan)',
          'mcoaparentcode' => $pajak_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $pajak_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $pajak_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1107.02',
          'mcoaname' => 'PPh Pasal 25',
          'mcoaparentcode' => $pajak_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $pajak_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $pajak_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1107.03',
          'mcoaname' => 'PPh Pasal 23',
          'mcoaparentcode' => $pajak_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $pajak_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $pajak_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1108.00',
        'mcoaparentname' => 'Biaya Dibayar Dimuka',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $biaya_dibayar_dimuka = MCOAParent::where('mcoaparentcode','1108.00')->first();

        MCOA::create([
          'mcoacode' => '1108.01',
          'mcoaname' => 'Asuransi Di Bayar Di Muka',
          'mcoaparentcode' => $biaya_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $biaya_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $biaya_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1108.02',
          'mcoaname' => 'Lisensi Software Dibayar Dimuka',
          'mcoaparentcode' => $biaya_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $biaya_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $biaya_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1108.03',
          'mcoaname' => 'Biaya Umum Dibayar Dimuka',
          'mcoaparentcode' => $biaya_dibayar_dimuka->mcoaparentcode,
          'mcoaparentname' => $biaya_dibayar_dimuka->mcoaparentname,
          'mcoatype' => $biaya_dibayar_dimuka->mcoaparenttype,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1109.00',
        'mcoaparentname' => 'Investasi Jangka Panjang',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $investasi_jangka_panjang = MCOAParent::where('mcoaparentcode','1109.00')->first();

        MCOA::create([
          'mcoacode' => '1109.01',
          'mcoaname' => 'Investasi Saham',
          'mcoatype' => $investasi_jangka_panjang->mcoaparenttype,
          'mcoaparentcode' => $investasi_jangka_panjang->mcoaparentcode,
          'mcoaparentname' => $investasi_jangka_panjang->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1109.02',
          'mcoaname' => 'Investasi Obligasi',
          'mcoatype' => $investasi_jangka_panjang->mcoaparenttype,
          'mcoaparentcode' => $investasi_jangka_panjang->mcoaparentcode,
          'mcoaparentname' => $investasi_jangka_panjang->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1110.00',
        'mcoaparentname' => 'Harta Lainya',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $harta_lainya = MCOAParent::where('mcoaparentcode','1110.00')->first();

        MCOA::create([
          'mcoacode' => '1110.01',
          'mcoaname' => 'Biaya Pra Operasi dan Operasi',
          'mcoatype' => $harta_lainya->mcoaparenttype,
          'mcoaparentcode' => $harta_lainya->mcoaparentcode,
          'mcoaparentname' => $harta_lainya->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1110.02',
          'mcoaname' => 'Akumulasi Amortisasi Pra Operasi dan Operasi',
          'mcoatype' => $harta_lainya->mcoaparenttype,
          'mcoaparentcode' => $harta_lainya->mcoaparentcode,
          'mcoaparentname' => $harta_lainya->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1201.00',
        'mcoaparentname' => 'Harta Tetap Berwujud',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $harta_tetap_berwujud = MCOAParent::where('mcoaparentcode','1201.00')->first();

        MCOA::create([
          'mcoacode' => '1201.01',
          'mcoaname' => 'Tanah',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.02',
          'mcoaname' => 'Bangunan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.03',
          'mcoaname' => 'Akumulasi Penyusutan Bangungan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.04',
          'mcoaname' => 'Mesin dan Peralatan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.05',
          'mcoaname' => 'Akumulasi Penyusutan Mesin dan Peralatan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.06',
          'mcoaname' => 'Mabel dan Alat Tulis Kantor',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.07',
          'mcoaname' => 'Akumulasi Penyusutan Mebel dan ATK',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.08',
          'mcoaname' => 'Kendaraan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.09',
          'mcoaname' => 'Akumulasi Penyusutan Kendaraan',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.10',
          'mcoaname' => 'Harta Tetap Lainya',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1201.11',
          'mcoaname' => 'Akumulasi Penyusutan Harta Tetap Lainya',
          'mcoatype' => $harta_tetap_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '1202.00',
        'mcoaparentname' => 'Harta Tetap Tidak Berwujud',
        'mcoaparenttype' => $harta->mcoagrandparenttype,
        'mcoagrandparentcode' => $harta->mcoagrandparentcode,
        'mcoagrandparentname' => $harta->mcoagrandparentname
      ]);

      $harta_tetap_tidak_berwujud = MCOAParent::where('mcoaparentcode','1202.00')->first();

        MCOA::create([
          'mcoacode' => '1202.01',
          'mcoaname' => 'Hak Merek',
          'mcoatype' => $harta_tetap_tidak_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_tidak_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_tidak_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1202.02',
          'mcoaname' => 'Hak Cipta',
          'mcoatype' => $harta_tetap_tidak_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_tidak_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_tidak_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '1202.03',
          'mcoaname' => 'Good Will',
          'mcoatype' => $harta_tetap_tidak_berwujud->mcoaparenttype,
          'mcoaparentcode' => $harta_tetap_tidak_berwujud->mcoaparentcode,
          'mcoaparentname' => $harta_tetap_tidak_berwujud->mcoaparentname,
          'mcoagrandparentcode' => $harta->mcoagrandparentcode,
          'mcoagrandparentname' => $harta->mcoagrandparentname
        ]);

      $kewajiban = MCOAGrandParent::where('mcoagrandparentcode','2000.00')->first();

      MCOAParent::create([
        'mcoaparentcode' => '2101.00',
        'mcoaparentname' => 'Hutang Lancar',
        'mcoaparenttype' => $kewajiban->mcoagrandparenttype,
        'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
        'mcoagrandparentname' => $kewajiban->mcoagrandparentname
      ]);

      $hutang_lancar = MCOAParent::where('mcoaparentcode','2101.00')->first();

        MCOA::create([
          'mcoacode' => '2101.01',
          'mcoaname' => 'Wesel Bayar',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.02',
          'mcoaname' => 'Hutang Giro',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.03',
          'mcoaname' => 'Hutang Usaha',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.04',
          'mcoaname' => 'Hutang Usaha (EUR)',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.05',
          'mcoaname' => 'Hutang Konsiyasi',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.06',
          'mcoaname' => 'Uang Muka Penjualan',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.07',
          'mcoaname' => 'Hutang Dividen',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.08',
          'mcoaname' => 'Hutang Bunga',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.09',
          'mcoaname' => 'Biaya Yang Masih Harus Di Bayar',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.10',
          'mcoaname' => 'Kartu Kredit',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.11',
          'mcoaname' => 'Hutang Komisi Penjualan',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.12',
          'mcoaname' => 'Hutang Gaji',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.13',
          'mcoaname' => 'Hutang Jangka Pendek',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.14',
          'mcoaname' => 'Unbilled Recieve',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.15',
          'mcoaname' => 'Unbilled-Receive-Service/Fee',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2101.16',
          'mcoaname' => 'Deposit Customer',
          'mcoatype' => $hutang_lancar->mcoaparenttype,
          'mcoaparentcode' => $hutang_lancar->mcoaparentcode,
          'mcoaparentname' => $hutang_lancar->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '2102.00',
        'mcoaparentname' => 'Hutang Pajak',
        'mcoaparenttype' => $kewajiban->mcoagrandparenttype,
        'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
        'mcoagrandparentname' => $kewajiban->mcoagrandparentname
      ]);

      $hutang_pajak = MCOAParent::where('mcoaparentcode','2102.00')->first();

        MCOA::create([
          'mcoacode' => '2102.01',
          'mcoaname' => 'Hutang Pajak Penjualan (PPn Keluaran)',
          'mcoatype' => $hutang_pajak->mcoaparenttype,
          'mcoaparentcode' => $hutang_pajak->mcoaparentcode,
          'mcoaparentname' => $hutang_pajak->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2102.02',
          'mcoaname' => 'PPh Pasal 23',
          'mcoatype' => $hutang_pajak->mcoaparenttype,
          'mcoaparentcode' => $hutang_pajak->mcoaparentcode,
          'mcoaparentname' => $hutang_pajak->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '2103.00',
        'mcoaparentname' => 'Pendapatan Di Terima Di Muka',
        'mcoaparenttype' => $kewajiban->mcoagrandparenttype,
        'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
        'mcoagrandparentname' => $kewajiban->mcoagrandparentname
      ]);

      $pendapatan_diterima_dimuka = MCOAParent::where('mcoaparentcode','2103.00')->first();

        MCOA::create([
          'mcoacode' => '2103.01',
          'mcoaname' => 'Sewa Di Terima Di Muka',
          'mcoatype' => $pendapatan_diterima_dimuka->mcoaparenttype,
          'mcoaparentcode' => $pendapatan_diterima_dimuka->mcoaparentcode,
          'mcoaparentname' => $pendapatan_diterima_dimuka->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '2201.00',
        'mcoaparentname' => 'Hutang Jangka Panjang',
        'mcoaparenttype' => $kewajiban->mcoagrandparenttype,
        'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
        'mcoagrandparentname' => $kewajiban->mcoagrandparentname
      ]);

      $hutang_jangka_panjang = MCOAParent::where('mcoaparentcode','2201.00')->first();

        MCOA::create([
          'mcoacode' => '2201.01',
          'mcoaname' => 'Pinjaman Hipotik',
          'mcoatype' => $hutang_jangka_panjang->mcoaparenttype,
          'mcoaparentcode' => $hutang_jangka_panjang->mcoaparentcode,
          'mcoaparentname' => $hutang_jangka_panjang->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '2201.02',
          'mcoaname' => 'Hutang Bank',
          'mcoatype' => $hutang_jangka_panjang->mcoaparenttype,
          'mcoaparentcode' => $hutang_jangka_panjang->mcoaparentcode,
          'mcoaparentname' => $hutang_jangka_panjang->mcoaparentname,
          'mcoagrandparentcode' => $kewajiban->mcoagrandparentcode,
          'mcoagrandparentname' => $kewajiban->mcoagrandparentname
        ]);

    $modal = MCOAGrandParent::where('mcoagrandparentcode','3000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '3100.00',
      'mcoaparentname' => 'Modal',
      'mcoaparenttype' => $modal->mcoagrandparenttype,
      'mcoagrandparentcode' => $modal->mcoagrandparentcode,
      'mcoagrandparentname' => $modal->mcoagrandparentname
    ]);

    $modalP = MCOAParent::where('mcoaparentcode','3100.00')->first();

        MCOA::create([
          'mcoacode' => '3100.01',
          'mcoaname' => 'Saldo Awal Modal',
          'mcoatype' => $modalP->mcoaparenttype,
          'mcoaparentcode' => $modalP->mcoaparentcode,
          'mcoaparentname' => $modalP->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '3100.02',
          'mcoaname' => 'Modal Di Setor',
          'mcoatype' => $modalP->mcoaparenttype,
          'mcoaparentcode' => $modalP->mcoaparentcode,
          'mcoaparentname' => $modalP->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '3100.03',
          'mcoaname' => 'Saham Biasa',
          'mcoatype' => $modalP->mcoaparenttype,
          'mcoaparentcode' => $modalP->mcoaparentcode,
          'mcoaparentname' => $modalP->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '3100.04',
          'mcoaname' => 'Saham Preferan',
          'mcoatype' => $modalP->mcoaparenttype,
          'mcoaparentcode' => $modalP->mcoaparentcode,
          'mcoaparentname' => $modalP->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '3200.00',
        'mcoaparentname' => 'Laba',
        'mcoaparenttype' => $modal->mcoagrandparenttype,
        'mcoagrandparentcode' => $modal->mcoagrandparentcode,
        'mcoagrandparentname' => $modal->mcoagrandparentname
      ]);

      $laba = MCOAParent::where('mcoaparentcode','3200.00')->first();

        MCOA::create([
          'mcoacode' => '3200.01',
          'mcoaname' => 'Laba Di Tahan',
          'mcoatype' => $laba->mcoaparenttype,
          'mcoaparentcode' => $laba->mcoaparentcode,
          'mcoaparentname' => $laba->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

        MCOA::create([
          'mcoacode' => '3200.02',
          'mcoaname' => 'Laba Tahun Berjalan',
          'mcoatype' => $laba->mcoaparenttype,
          'mcoaparentcode' => $laba->mcoaparentcode,
          'mcoaparentname' => $laba->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

      MCOAParent::create([
        'mcoaparentcode' => '3300.00',
        'mcoaparentname' => 'Dividen',
        'mcoaparenttype' => $modal->mcoagrandparenttype,
        'mcoagrandparentcode' => $modal->mcoagrandparentcode,
        'mcoagrandparentname' => $modal->mcoagrandparentname
      ]);

      $dividen = MCOAParent::where('mcoaparentcode','3300.00')->first();

        MCOA::create([
          'mcoacode' => '3300.01',
          'mcoaname' => 'Dividen Kas',
          'mcoatype' => $dividen->mcoaparenttype,
          'mcoaparentcode' => $dividen->mcoaparentcode,
          'mcoaparentname' => $dividen->mcoaparentname,
          'mcoagrandparentcode' => $modal->mcoagrandparentcode,
          'mcoagrandparentname' => $modal->mcoagrandparentname
        ]);

    $pendapatan = MCOAGrandParent::where('mcoagrandparentcode','4000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '4100.00',
      'mcoaparentname' => 'Pendapatan Usaha',
      'mcoaparenttype' => $pendapatan->mcoagrandparenttype,
      'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
      'mcoagrandparentname' => $pendapatan->mcoagrandparentname
    ]);

    $pendapatan_usaha = MCOAParent::where('mcoaparentcode','4100.00')->first();

      MCOA::create([
        'mcoacode' => '4100.01',
        'mcoaname' => 'Penjualan',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.02',
        'mcoaname' => 'Pendapatan Jasa',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.03',
        'mcoaname' => 'Penjualan Lain',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.04',
        'mcoaname' => 'Retur Penjualan',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.05',
        'mcoaname' => 'Potongan Penjualan',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.06',
        'mcoaname' => 'Pendapatan Denda Keterlambatan',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '4100.07',
        'mcoaname' => 'Pendapatan atas Pengantaran',
        'mcoatype' => $pendapatan_usaha->mcoaparenttype,
        'mcoaparentcode' => $pendapatan_usaha->mcoaparentcode,
        'mcoaparentname' => $pendapatan_usaha->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan->mcoagrandparentname
      ]);

    $biaya_atas_pendapatan = MCOAGrandParent::where('mcoagrandparentcode','5000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '5100.00',
      'mcoaparentname' => 'Beban Pokok Penjualan',
      'mcoaparenttype' => $biaya_atas_pendapatan->mcoagrandparenttype,
      'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
      'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
    ]);

    $beban_pokok_penjualan = MCOAParent::where('mcoaparentcode','5100.00')->first();

      MCOA::create([
        'mcoacode' => '5100.01',
        'mcoaname' => 'Harga Pokok Pejualan',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.02',
        'mcoaname' => 'Biaya 1',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.03',
        'mcoaname' => 'Biaya 2',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.04',
        'mcoaname' => 'Komisi Penjualan',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.05',
        'mcoaname' => 'Retur Pembelian',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.06',
        'mcoaname' => 'Biaya Angkut Pembelian',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.07',
        'mcoaname' => 'Potongan Pembelian',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5100.08',
        'mcoaname' => 'Bonus',
        'mcoatype' => $beban_pokok_penjualan->mcoaparenttype,
        'mcoaparentcode' => $beban_pokok_penjualan->mcoaparentcode,
        'mcoaparentname' => $beban_pokok_penjualan->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

    MCOAParent::create([
      'mcoaparentcode' => '5200.00',
      'mcoaparentname' => 'Biaya Lain',
      'mcoaparenttype' => $biaya_atas_pendapatan->mcoagrandparenttype,
      'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
      'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
    ]);

    $biaya_lain = MCOAParent::where('mcoaparentcode','5200.00')->first();

      MCOA::create([
        'mcoacode' => '5200.01',
        'mcoaname' => 'Kerugian Selisih Piutang',
        'mcoatype' => $biaya_lain->mcoaparenttype,
        'mcoaparentcode' => $biaya_lain->mcoaparentcode,
        'mcoaparentname' => $biaya_lain->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5200.02',
        'mcoaname' => 'Biaya Denda Keterlambatan',
        'mcoatype' => $biaya_lain->mcoaparenttype,
        'mcoaparentcode' => $biaya_lain->mcoaparentcode,
        'mcoaparentname' => $biaya_lain->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5200.03',
        'mcoaname' => 'Kerusakan dan Kegagalan Material',
        'mcoatype' => $biaya_lain->mcoaparenttype,
        'mcoaparentcode' => $biaya_lain->mcoaparentcode,
        'mcoaparentname' => $biaya_lain->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '5200.04',
        'mcoaname' => 'Biaya Lain-lain',
        'mcoatype' => $biaya_lain->mcoaparenttype,
        'mcoaparentcode' => $biaya_lain->mcoaparentcode,
        'mcoaparentname' => $biaya_lain->mcoaparentname,
        'mcoagrandparentcode' => $biaya_atas_pendapatan->mcoagrandparentcode,
        'mcoagrandparentname' => $biaya_atas_pendapatan->mcoagrandparentname
      ]);

    $pengeluaran_operasional = MCOAGrandParent::where('mcoagrandparentcode','6000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '6100.00',
      'mcoaparentname' => 'Biaya Operasional',
      'mcoaparenttype' => $pengeluaran_operasional->mcoagrandparenttype,
      'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
      'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
    ]);

    $biaya_operasional = MCOAParent::where('mcoaparentcode','6100.00')->first();

      MCOA::create([
        'mcoacode' => '6100.01',
        'mcoaname' => 'Gaji Direksi dan Karyawan',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.02',
        'mcoaname' => 'Biaya Listrik',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.03',
        'mcoaname' => 'Promosi dan Iklan',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.04',
        'mcoaname' => 'Biaya Umum ATK Operasional Kantor',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.05',
        'mcoaname' => 'Biaya Air (PDAM)',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.06',
        'mcoaname' => 'Biaya Lembur Karyawan',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.07',
        'mcoaname' => 'Biaya Telpon dan Internet Kantor',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.08',
        'mcoaname' => 'Biaya Perlengkapan Umum',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.09',
        'mcoaname' => 'Biaya Lisensi Software',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.10',
        'mcoaname' => 'Biaya Loading Barang Bongkaran',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.11',
        'mcoaname' => 'Biaya Ongkos Kirim Dokumen Kantor',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6100.12',
        'mcoaname' => 'Biaya Legal atau Pengurusan Izin',
        'mcoatype' => $biaya_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

    MCOAParent::create([
      'mcoaparentcode' => '6200.00',
      'mcoaparentname' => 'Biaya Non Operasional',
      'mcoaparenttype' => $pengeluaran_operasional->mcoagrandparenttype,
      'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
      'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
    ]);

    $biaya_non_operasional = MCOAParent::where('mcoaparentcode','6200.00')->first();

      MCOA::create([
        'mcoacode' => '6200.01',
        'mcoaname' => 'Penyusutan Bangunan',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6200.02',
        'mcoaname' => 'Penyusutan Mesin dan Peralatan',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6200.03',
        'mcoaname' => 'Penyusutan Mebel dan ATK',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6200.04',
        'mcoaname' => 'Penyusutan Kendaraan',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6200.05',
        'mcoaname' => 'Penyusutan Harta Lainnya',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '6200.06',
        'mcoaname' => 'Amortisasi Pra Operasi dan Operasi',
        'mcoatype' => $biaya_non_operasional->mcoaparenttype,
        'mcoaparentcode' => $biaya_non_operasional->mcoaparentcode,
        'mcoaparentname' => $biaya_non_operasional->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_operasional->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_operasional->mcoagrandparentname
      ]);

    $pendapatan_luar_usaha = MCOAGrandParent::where('mcoagrandparentcode','7000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '7100.00',
      'mcoaparentname' => 'Pendapatan Luar Usaha',
      'mcoaparenttype' => $pendapatan_luar_usaha->mcoagrandparenttype,
      'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
      'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
    ]);

    $plu = MCOAParent::where('mcoaparentcode','7100.00')->first();

      MCOA::create([
        'mcoacode' => '7100.01',
        'mcoaname' => 'Pendapatan Surcharge',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.02',
        'mcoaname' => 'Merchant Discount Rate',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.03',
        'mcoaname' => 'Hasil Sewa',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.04',
        'mcoaname' => 'FCN Debet',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.05',
        'mcoaname' => 'Laba Rugi Selisih Kurs',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.06',
        'mcoaname' => 'Laba Rugi Penjualan Harta Tetap',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.07',
        'mcoaname' => 'Free Goods',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '7100.08',
        'mcoaname' => 'P/K Selisih Hutang',
        'mcoatype' => $plu->mcoaparenttype,
        'mcoaparentcode' => $plu->mcoaparentcode,
        'mcoaparentname' => $plu->mcoaparentname,
        'mcoagrandparentcode' => $pendapatan_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pendapatan_luar_usaha->mcoagrandparentname
      ]);

    $pengeluaran_luar_usaha = MCOAGrandParent::where('mcoagrandparentcode','8000.00')->first();

    MCOAParent::create([
      'mcoaparentcode' => '8100.00',
      'mcoaparentname' => 'Pengeluaran Luar Usaha',
      'mcoaparenttype' => $pengeluaran_luar_usaha->mcoagrandparenttype,
      'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
      'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
    ]);

    $pluu = MCOAParent::where('mcoaparentcode','8100.00')->first();

      MCOA::create([
        'mcoacode' => '8100.01',
        'mcoaname' => 'Biaya Bunga',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.02',
        'mcoaname' => 'Jasa Bank',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.03',
        'mcoaname' => 'FCN Kredit',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.04',
        'mcoaname' => 'P/K Selisih Kredit',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.05',
        'mcoaname' => 'P/K Selisih Kas',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.06',
        'mcoaname' => 'P/K Selisih Stock',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.07',
        'mcoaname' => 'P/K Selisih Piutang',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

      MCOA::create([
        'mcoacode' => '8100.08',
        'mcoaname' => 'Unbilled Cost',
        'mcoatype' => $pluu->mcoaparenttype,
        'mcoaparentcode' => $pluu->mcoaparentcode,
        'mcoaparentname' => $pluu->mcoaparentname,
        'mcoagrandparentcode' => $pengeluaran_luar_usaha->mcoagrandparentcode,
        'mcoagrandparentname' => $pengeluaran_luar_usaha->mcoagrandparentname
      ]);

    }
}
