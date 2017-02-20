<div id="branchswitcher" style="padding:10px;">
    <changer active="{{ $active }}"></changer>
</div>
<ul>
  @if($active == 'dashboard')
    <li class="active">
      <a href="{{ url('admin-nano/index') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
    </li>
  @else
    <li>
      <a href="{{ url('admin-nano/index') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
    </li>
  @endif
  @if(Auth::user()->has_role('R_config'))
      <li>
        <a href="#"><i class="fa fa-lg fa-fw fa-cogs"></i> <span class="menu-item-parent">Setting Sistem</span></a>
        <ul>
          @if($active == 'sysparam')
            <li class="active"><a href="{{ url('admin-nano/mconfig/sysparam') }}">Parameter Sistem</a></li>
          @else
            <li><a href="{{ url('admin-nano/mconfig/sysparam') }}">Parameter Sistem</a></li>
          @endif
          @if($active == 'sysfeature')
            <li class="active"><a href="{{ url('admin-nano/mconfig/sysfeature') }}">Setting Fitur</a></li>
          @else
            <li><a href="{{ url('admin-nano/mconfig/sysfeature') }}">Setting Fitur</a></li>
          @endif
          <li><a href="">Setting Laporan</a></li>
        </ul>
      </li>
  @endif
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Akutansi</span></a>
    <ul>
        @if(Auth::user()->has_role('R_mcoa'))
            @if($active == 'mcoa')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/mcoa">Master Akun</a>
              </li>
            @else
            <li>
              <a href="{{URL::to('/')}}/admin-nano/mcoa">Master Akun</a>
            </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_generaljournal'))
            @if($active == 'generaljournal')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/generaljournal">Jurnal Umum</a>
              </li>
            @else
              <li>
              <a href="{{URL::to('/')}}/admin-nano/generaljournal">Jurnal Umum</a>
              </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_fixedasset'))
            @if($active == 'categoryfixedassets')
              <li class="active"><a href="{{ url('admin-nano/mcategoryfixedassets') }}">Master Kategori Aset Tetap</a></li>
            @else
              <li><a href="{{ url('admin-nano/mcategoryfixedassets') }}">Master Kategori Aset Tetap</a></li>
            @endif
            <li><a href="">Pembelian Aset Tetap</a></li>
        @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Kas Bank</span></a>
    <ul>
        @if(Auth::user()->has_role('R_cashbank'))
            @if($active == 'cashbank')
              <li class="active">
                <a href="{{ url('/admin-nano/cashbank/list') }}">Daftar Kas / Bank</a>
              </li>
            @else
            <li>
              <a href="{{ url('/admin-nano/cashbank/list') }}">Daftar Kas / Bank</a>
            </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_cashbankincome'))
            @if($active == 'cashbankincome')
              <li class="active">
                <a href="{{ url('/admin-nano/cashbank/income') }}">Penerimaan Kas / Bank</a>
              </li>
            @else
            <li>
              <a href="{{ url('/admin-nano/cashbank/income') }}">Penerimaan Kas / Bank</a>
            </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_cashbankoutcome'))
            @if($active == 'cashbankoutcome')
              <li class="active">
                <a href="{{ url('/admin-nano/cashbank/outcome') }}">Pengeluaran Kas / Bank</a>
              </li>
            @else
            <li>
              <a href="{{ url('/admin-nano/cashbank/outcome') }}">Pengeluaran Kas / Bank</a>
            </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_cashbanktransfer'))
            @if($active == 'cashbanktransfer')
                <li class="active">
                    <a href="{{ url('/admin-nano/cashbank/transfer') }}">Transfer Kas / Bank</a>
                </li>
            @else
                <li>
                    <a href="{{ url('/admin-nano/cashbank/transfer') }}">Transfer Kas / Bank</a>
                </li>
            @endif
        @endif
        <li><a href="">Rekonsal Kas / Bank</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-shopping-cart"></i> <span class="menu-item-parent">Pembelian</span></a>
    <ul>
        @if(Auth::user()->has_role('R_purchase'))
            @if($active == 'purchaseinvoice')
              <li class="active"><a href="{{ url('admin-nano/purchaseinvoice') }}">Pembelian</a></li>
            @else
              <li><a href="{{ url('admin-nano/purchaseinvoice') }}">Pembelian</a></li>
            @endif
        @endif

            @if($active == 'purchasequotation')
              <li class="active"><a href="{{ url('admin-nano/purchasequotation') }}">Purchase Order</a></li>
            @else
              <li><a href="{{ url('admin-nano/purchasequotation') }}">Penawaran Pembelian</a></li>
            @endif

        @if(Auth::user()->has_role('R_payap'))
            @if($active == 'payap')
              <li class="active"><a href="{{ url('admin-nano/payap') }}">Pembayaran Hutang Dagang</a></li>
            @else
              <li><a href="{{ url('admin-nano/payap') }}">Pembayaran Hutang Dagang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_supplier'))
            @if($active == 'supplier')
              <li class="active"><a href="{{ url('admin-nano/msupplier') }}">Master Supplier</a></li>
            @else
              <li><a href="{{ url('admin-nano/msupplier') }}">Master Supplier</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_categorysupplier'))
            @if($active == 'categorysupllier')
              <li class="active"><a href="{{ url('admin-nano/mcategorysupplier') }}">Master Kategori Supplier</a></li>
            @else
              <li><a href="{{ url('admin-nano/mcategorysupplier') }}">Master Kategori Supplier</a></li>
            @endif
        @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-tag"></i> <span class="menu-item-parent">Penjualan</span></a>
    <ul>
        @if(Auth::user()->has_role('R_sales'))
            @if($active == 'salesinvoice')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/salesinvoice">Transaksi Penjualan</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/salesinvoice">Transaksi Penjualan</a>
              </li>
            @endif
        @endif

            @if($active == 'invoicequotation')
              <li class="active"><a href="{{ url('admin-nano/invoicequotation') }}">Penawaran Pembelian</a></li>
            @else
              <li><a href="{{ url('admin-nano/purchasequotation') }}">Penawaran Pembelian</a></li>
            @endif

        @if(Auth::user()->has_role('R_payar'))
            @if($active == 'payar')
              <li class="active"><a href="{{ url('admin-nano/payar') }}">Pembayaran Piutang Dagang</a></li>
            @else
              <li><a href="{{ url('admin-nano/payar') }}">Pembayaran Piutang Dagang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_customer'))
            @if($active == 'customer')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/pelanggan">Master Customer</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/pelanggan">Master Customer</a>
              </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_categorycustomer'))
            @if($active == 'categorycustomer')
              <li class="active"><a href="{{ url('admin-nano/mcategorycustomer') }}">Master Kategori Customer</a></li>
            @else
              <li><a href="{{ url('admin-nano/mcategorycustomer') }}">Master Kategori Customer</a></li>
            @endif
        @endif
        <li><a href="">Master Kategori Harga</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Inventory</span></a>
    <ul>
        @if(Auth::user()->has_role('R_goods'))
            @if($active == 'barang')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/barang">Master Barang</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/barang">Master Barang</a>
              </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_units'))
            @if($active == 'munit')
              <li class="active"><a href="{{ url('admin-nano/munits') }}">Master Satuan Barang</a></li>
            @else
              <li><a href="{{ url('admin-nano/munits') }}">Master Satuan Barang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_brands'))
            @if($active == 'mgoodsmark')
              <li class="active"><a href="{{ url('admin-nano/mcategorygoodsmark')}}">Master Merek Barang</a></li>
            @else
              <li><a href="{{ url('admin-nano/mcategorygoodsmark')}}">Master Merek Barang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_goodstype'))
            @if($active == 'mgoodstype')
              <li class="active"><a href="{{ url('admin-nano/mgoodstype')}}">Master Tipe Barang</a></li>
            @else
              <li><a href="{{ url('admin-nano/mgoodstype')}}">Master Tipe Barang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_goodssubtype'))
            @if($active == 'mgoodssubtype')
              <li class="active"><a href="{{ url('admin-nano/mgoodssubtype')}}">Master Sub Tipe Barang</a></li>
            @else
              <li><a href="{{ url('admin-nano/mgoodssubtype')}}">Master Sub Tipe Barang</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_warehouse'))
            @if($active == 'mwarehouse')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/mwarehouse">Master Gudang</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/mwarehouse">Master Gudang</a>
              </li>
            @endif
        @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Lain-lain</span></a>
    <ul>
        @if(Auth::user()->has_role('R_employee'))
            @if($active == 'memployee')
              <li class="active"><a href="{{ url('admin-nano/memployee') }}">Master Karyawan</a></li>
            @else
              <li><a href="{{ url('admin-nano/memployee') }}">Master Karyawan</a></li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_employeelevel'))
            @if($active == 'memployeelevel')
              <li class="active"><a href="{{ url('admin-nano/memployeelevel')}}">Master Level Karyawan</a></li>
            @else
              <li><a href="{{ url('admin-nano/memployeelevel')}}">Master Level Karyawan</a></li>
            @endif
        @endif
        <li><a href="">Master Mata Uang</a></li>
        @if(Auth::user()->has_role('R_tax'))
            @if($active == 'mtax')
              <li class="active"><a href="{{ url('admin-nano/mtax') }}">Master Pajak</a></li>
            @else
              <li><a href="{{ url('admin-nano/mtax') }}">Master Pajak</a></li>
            @endif
        @endif
        <li><a href="">Master Penggajian Pegawai</a></li>
        @if(Auth::user()->has_role('R_branch'))
            @if($active == 'cabang')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
              </li>
            @endif
        @endif
        @if(Auth::user()->is_admin())
            @if($active == 'roles')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/roles">Hak Akses</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/roles">Hak Akses</a>
              </li>
            @endif
        @endif
        @if(Auth::user()->has_role('R_user'))
            @if($active == 'muser')
              <li class="active">
                <a href="{{URL::to('/')}}/admin-nano/muser">Master User</a>
              </li>
            @else
              <li>
                <a href="{{URL::to('/')}}/admin-nano/muser">Master User</a>
              </li>
            @endif
        @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Laporan</span></a>
    <ul>
        <li>
            <a href="#">Keuangan</a>
            <ul>
                @if(Auth::user()->has_role('R_journal'))
                    @if($active == 'journal')
                      <li class="active"><a href="{{ url('admin-nano/reports/journal') }}">Jurnal</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/journal') }}">Jurnal</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_ledger'))
                    @if($active == 'ledger')
                      <li class="active"><a href="{{ url('admin-nano/reports/ledger') }}">Buku Besar</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/ledger') }}">Buku Besar</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_stockvaluereport'))
                    @if($active == 'cogshistory')
                      <li class="active"><a href="{{ url('admin-nano/reports/cogshistory') }}">Laporan History HPP</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/cogshistory') }}">Laporan History HPP</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_journal'))
                    @if($active == 'purchasejournal')
                      <li class="active"><a href="{{ url('admin-nano/reports/purchasejournal') }}">Laporan Jurnal Pembelian</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/purchasejournal') }}">Laporan Jurnal Pembelian</a></li>
                    @endif
                    @if($active == 'salesjournal')
                      <li class="active"><a href="{{ url('admin-nano/reports/salesjournal') }}">Laporan Jurnal Penjualan</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/salesjournal') }}">Laporan Jurnal Penjualan</a></li>
                    @endif
                @endif
			</ul>
        </li>
        <li>
            <a href="#">Inventory</a>
            <ul>
                @if(Auth::user()->has_role('R_stockreport'))
                    @if($active == 'mstockcardreport')
                      <li class="active"><a href="{{ url('admin-nano/mstockcardreport') }}">Laporan Stock</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/mstockcardreport') }}">Laporan Stock</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_stockvaluereport'))
                    @if($active == 'stockvalue')
                      <li class="active"><a href="{{ url('admin-nano/reports/stockvalue') }}">Laporan Nilai Persediaan</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/stockvalue') }}">Laporan Nilai Persediaan</a></li>
                    @endif
                @endif
			</ul>
        </li>
        <li>
            <a href="#">Penjualan</a>
            <ul>
                @if(Auth::user()->has_role('R_salesreport'))
                    @if($active == 'salesreports')
                      <li class="active"><a href="{{ url('admin-nano/reports/salesreport') }}">Laporan Penjualan</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/salesreport') }}">Laporan Penjualan</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_arcustomerreport'))
                    @if($active == 'arcustreport')
                      <li class="active"><a href="{{ url('admin-nano/reports/arcustreport') }}">Laporan Piutang Customer</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/arcustreport') }}">Laporan Piutang Customer</a></li>
                    @endif
                    @if($active == 'arbook')
                      <li class="active"><a href="{{ url('admin-nano/reports/arbook') }}">Laporan Buku Piutang</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/arbook') }}">Laporan Buku Piutang</a></li>
                    @endif
                @endif
			</ul>
        </li>
        <li>
            <a href="#">Pembelian</a>
            <ul>
                @if(Auth::user()->has_role('R_purchasereport'))
                    @if($active == 'purchasereport')
                      <li class="active"><a href="{{ url('admin-nano/reports/purchasereport') }}">Laporan Pembelian</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/purchasereport') }}">Laporan Pembelian</a></li>
                    @endif
                @endif
                @if(Auth::user()->has_role('R_apreport'))
                    @if($active == 'apreport')
                      <li class="active"><a href="{{ url('admin-nano/reports/apreport') }}">Laporan Hutang Dagang</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/apreport') }}">Laporan Hutang Dagang</a></li>
                    @endif
                    @if($active == 'apbook')
                      <li class="active"><a href="{{ url('admin-nano/reports/apbook') }}">Laporan Buku Hutang</a></li>
                    @else
                      <li><a href="{{ url('admin-nano/reports/apbook') }}">Laporan Buku Hutang</a></li>
                    @endif
                @endif
			</ul>
        </li>
        <li>
            <a href="#">Audit</a>
            <ul>
			    <li><a href="forum.html">Laporan Kartu Stok</a></li>
				<li><a href="forum-topic.html">Laporan Penjualan</a></li>
				<li><a href="forum-post.html">Laporan Pembelian</a></li>
			</ul>
        </li>
    </ul>
  </li>
</ul>
