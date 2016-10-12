<ul>
  <li>
    <a href="{{URL::to('admin-nano')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
  </li>
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
      <li><a href="">Master Kategori Aset Tetap</a></li>
      <li><a href="">Pembelian Aset Tetap</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Kas Bank</span></a>
    <ul>
      <li><a href="">Daftar Kas / Bank</a></li>
      <li><a href="">Penerimaan Kas / Bank</a></li>
      <li><a href="">Pengeluaran Kas / Bank</a></li>
      <li><a href="">Rekonsal Kas / Bank</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-shopping-cart"></i> <span class="menu-item-parent">Pembelian</span></a>
    <ul>
      <li><a href="">Master Supplier</a></li>
      <li><a href="">Master Kategori Supplier</a></li>
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
      <li><a href="">Master Kategori Customer</a></li>
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
      <li><a href="">Master Kategori Barang</a></li>
      <li><a href="">Master Merek Barang</a></li>
    </ul>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Lain-lain</span></a>
    <ul>
      <li><a href="">Master Karyawan</a></li>
      <li><a href="">Master Mata Uang</a></li>
      <li><a href="">Master Pajak</a></li>
      <li><a href="">Master Penggajian Pegawai</a></li>
    </ul>
  </li>
  <li class="">
    <a href="{{URL::to('admin-nano')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-clipboard"></i> <span class="menu-item-parent">Laporan</span></a>
  </li>
  <li>
    <a href="#"><i class="fa fa-lg fa-fw fa-random"></i> <span class="menu-item-parent">Cabang</span></a>
    <ul>
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
