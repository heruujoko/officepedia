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
      @if($active == 'categorygoods')
        <li class="active"><a href="{{ url('admin-nano/mcategorygoods') }}">Master Kategori Barang</a></li>
      @else
        <li><a href="{{ url('admin-nano/mcategorygoods') }}">Master Kategori Barang</a></li>
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
    </ul>
  </li>
</ul>
