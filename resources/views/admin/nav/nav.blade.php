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
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Akutansi</span></a>
    <ul>
      @if($active == 'mcoa')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/mcoa">Master Akun</a>
        </li>
      @else
      <li>
        <a href="{{URL::to('/')}}/admin-nano/mcoa">Master Akun</a>
      </li>
      @endif
      @if($active == 'categoryfixedassets')
        <li class="active"><a href="{{ url('admin-nano/mcategoryfixedassets') }}">Master Kategori Aset Tetap</a></li>
      @else
        <li><a href="{{ url('admin-nano/mcategoryfixedassets') }}">Master Kategori Aset Tetap</a></li>
      @endif
      <li><a href="">Pembelian Aset Tetap</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Kas Bank</span></a>
    <ul>
      @if($active == 'cashbank')
        <li class="active">
          <a href="{{ url('/admin-nano/cashbank/list') }}">Daftar Kas / Bank</a>
        </li>
      @else
      <li>
        <a href="{{ url('/admin-nano/cashbank/list') }}">Daftar Kas / Bank</a>
      </li>
      @endif
      <li><a href="">Penerimaan Kas / Bank</a></li>
      <li><a href="">Pengeluaran Kas / Bank</a></li>
      <li><a href="">Rekonsal Kas / Bank</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-shopping-cart"></i> <span class="menu-item-parent">Pembelian</span></a>
    <ul>
        @if($active == 'purchaseinvoice')
          <li class="active"><a href="{{ url('admin-nano/purchaseinvoice') }}">Pembelian</a></li>
        @else
          <li><a href="{{ url('admin-nano/purchaseinvoice') }}">Pembelian</a></li>
        @endif
        @if($active == 'payap')
          <li class="active"><a href="{{ url('admin-nano/payap') }}">Pembayaran Hutang Dagang</a></li>
        @else
          <li><a href="{{ url('admin-nano/payap') }}">Pembayaran Hutang Dagang</a></li>
        @endif
      @if($active == 'supplier')
        <li class="active"><a href="{{ url('admin-nano/msupplier') }}">Master Supplier</a></li>
      @else
        <li><a href="{{ url('admin-nano/msupplier') }}">Master Supplier</a></li>
      @endif
      @if($active == 'categorysupllier')
        <li class="active"><a href="{{ url('admin-nano/mcategorysupplier') }}">Master Kategori Supplier</a></li>
      @else
        <li><a href="{{ url('admin-nano/mcategorysupplier') }}">Master Kategori Supplier</a></li>
      @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-tag"></i> <span class="menu-item-parent">Penjualan</span></a>
    <ul>
      @if($active == 'salesinvoice')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/salesinvoice">Transaksi Penjualan</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/salesinvoice">Transaksi Penjualan</a>
        </li>
      @endif
      @if($active == 'payar')
        <li class="active"><a href="{{ url('admin-nano/payar') }}">Pembayaran Piutang Dagang</a></li>
      @else
        <li><a href="{{ url('admin-nano/payar') }}">Pembayaran Piutang Dagang</a></li>
      @endif
      @if($active == 'customer')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/pelanggan">Master Customer</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/pelanggan">Master Customer</a>
        </li>
      @endif
      @if($active == 'categorycustomer')
        <li class="active"><a href="{{ url('admin-nano/mcategorycustomer') }}">Master Kategori Customer</a></li>
      @else
        <li><a href="{{ url('admin-nano/mcategorycustomer') }}">Master Kategori Customer</a></li>
      @endif
      <li><a href="">Master Kategori Harga</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Inventory</span></a>
    <ul>
      @if($active == 'barang')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/barang">Master Barang</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/barang">Master Barang</a>
        </li>
      @endif
      @if($active == 'munit')
        <li class="active"><a href="{{ url('admin-nano/munits') }}">Master Satuan Barang</a></li>
      @else
        <li><a href="{{ url('admin-nano/munits') }}">Master Satuan Barang</a></li>
      @endif
      @if($active == 'mgoodsmark')
        <li class="active"><a href="{{ url('admin-nano/mcategorygoodsmark')}}">Master Merek Barang</a></li>
      @else
        <li><a href="{{ url('admin-nano/mcategorygoodsmark')}}">Master Merek Barang</a></li>
      @endif
      @if($active == 'mgoodstype')
        <li class="active"><a href="{{ url('admin-nano/mgoodstype')}}">Master Tipe Barang</a></li>
      @else
        <li><a href="{{ url('admin-nano/mgoodstype')}}">Master Tipe Barang</a></li>
      @endif
      @if($active == 'mgoodssubtype')
        <li class="active"><a href="{{ url('admin-nano/mgoodssubtype')}}">Master Sub Tipe Barang</a></li>
      @else
        <li><a href="{{ url('admin-nano/mgoodssubtype')}}">Master Sub Tipe Barang</a></li>
      @endif
      @if($active == 'mwarehouse')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/mwarehouse">Master Gudang</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/mwarehouse">Master Gudang</a>
        </li>
      @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Lain-lain</span></a>
    <ul>
      @if($active == 'memployee')
        <li class="active"><a href="{{ url('admin-nano/memployee') }}">Master Karyawan</a></li>
      @else
        <li><a href="{{ url('admin-nano/memployee') }}">Master Karyawan</a></li>
      @endif
      @if($active == 'memployeelevel')
        <li class="active"><a href="{{ url('admin-nano/memployeelevel')}}">Master Level Karyawan</a></li>
      @else
        <li><a href="{{ url('admin-nano/memployeelevel')}}">Master Level Karyawan</a></li>
      @endif
      <li><a href="">Master Mata Uang</a></li>
      @if($active == 'mtax')
        <li class="active"><a href="{{ url('admin-nano/mtax') }}">Master Pajak</a></li>
      @else
        <li><a href="{{ url('admin-nano/mtax') }}">Master Pajak</a></li>
      @endif
      <li><a href="">Master Penggajian Pegawai</a></li>
      @if($active == 'cabang')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
        </li>
      @endif
      @if($active == 'muser')
        <li class="active">
          <a href="{{URL::to('/')}}/admin-nano/muser">Master User</a>
        </li>
      @else
        <li>
          <a href="{{URL::to('/')}}/admin-nano/muser">Master User</a>
        </li>
      @endif
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Laporan</span></a>
    <ul>
      @if($active == 'mstockcardreport')
        <li class="active"><a href="{{ url('admin-nano/mstockcardreport') }}">Laporan Stock</a></li>
      @else
        <li><a href="{{ url('admin-nano/mstockcardreport') }}">Laporan Stock</a></li>
      @endif
      @if($active == 'salesreports')
        <li class="active"><a href="{{ url('admin-nano/reports/salesreport') }}">Laporan Penjualan</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/salesreport') }}">Laporan Penjualan</a></li>
      @endif
      @if($active == 'invoicereports')
        <li class="active"><a href="{{ url('admin-nano/reports/invoicereport') }}">Laporan Penjualan Invoice</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/invoicereport') }}">Laporan Penjualan Invoice</a></li>
      @endif
      @if($active == 'arreports')
        <li class="active"><a href="{{ url('admin-nano/reports/arreport') }}">Laporan Piutang</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/arreport') }}">Laporan Piutang</a></li>
      @endif
      @if($active == 'arcustreport')
        <li class="active"><a href="{{ url('admin-nano/reports/arcustreport') }}">Laporan Piutang Customer</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/arcustreport') }}">Laporan Piutang Customer</a></li>
      @endif
      @if($active == 'purchasereport')
        <li class="active"><a href="{{ url('admin-nano/reports/purchasereport') }}">Laporan Pembelian</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/purchasereport') }}">Laporan Pembelian</a></li>
      @endif
      @if($active == 'apreport')
        <li class="active"><a href="{{ url('admin-nano/reports/apreport') }}">Laporan Hutang Dagang</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/apreport') }}">Laporan Hutang Dagang</a></li>
      @endif
      @if($active == 'stockvalue')
        <li class="active"><a href="{{ url('admin-nano/reports/stockvalue') }}">Laporan Nilai Persediaan</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/stockvalue') }}">Laporan Nilai Persediaan</a></li>
      @endif
      @if($active == 'cogshistory')
        <li class="active"><a href="{{ url('admin-nano/reports/cogshistory') }}">Laporan History HPP</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/cogshistory') }}">Laporan History HPP</a></li>
      @endif
      @if($active == 'journal')
        <li class="active"><a href="{{ url('admin-nano/reports/journal') }}">Jurnal</a></li>
      @else
        <li><a href="{{ url('admin-nano/reports/journal') }}">Jurnal</a></li>
      @endif
    </ul>
  </li>
</ul>
