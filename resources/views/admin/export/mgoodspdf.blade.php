<html>
  <head>
    <style>
    table {
        background-color: transparent;
        font-size: 12px;
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
        padding: 4px;
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
    .tree li {
      list-style-type: none;
      margin: 0;
      padding: 5px;
      position: relative;
    }

    .bfr{
      border-left: 1px solid #999;
      bottom: 50px;
      height: 100%;
      top: -8px;
      width: 1px;
      content: '';
      left: -20px;
      position: absolute;
      right: auto;
    }
    .aftr{
      border-top: 1px solid #999 !important;
      height: 20px;
      top: 18px;
      width: 25px;
      content: '';
      left: -20px;
      position: absolute;
      right: auto;
    }
    .lc {
      height: 30px;
    }
    </style>
  </head>
  <body>
    <table class="table" style="font-size: 10px;width: 100%;">
      <tbody>
        <tr>
          <td><b>Kode</b></td>
          <td><b>Barcode</b></td>
          <td><b>Nama</b></td>
          <td><b>Alias</b></td>
          <td><b>Tipe</b></td>
          <td><b>Brand</b></td>
          <td><b>Group1</b></td>
          <td><b>Group2</b></td>
          <td><b>Group3</b></td>
          <td><b>Remark</b></td>
          <td><b>Unit</b></td>
          <td><b>Unit2</b></td>
          <td><b>Unit3</b></td>
          <td><b>Kode Supplier</b></td>
          <td><b>Nama Supplier</b></td>
          <td><b>Harga Masuk</b></td>
          <td><b>Harga Keluar</b></td>
          <td><b>Purchasing</b></td>
          <td><b>Nama Purchasing</b></td>
          <td><b>Akun COGS</b></td>
          <td><b>Nama Akun COGS</b></td>
          <td><b>Selling</b></td>
          <td><b>Nama Selling</b></td>
          <td><b>Return Of Selling</b></td>
          <td><b>Nama Return Of Selling</b></td>
          <td><b>COGS</b></td>
          <td><b>Transaksi Unik</b></td>
          <td><b>Cabang</b></td>
          <td><b>Gambar</b></td>
          <td><b>Convert Unit 2</b></td>
          <td><b>Convert Unit 3</b></td>
        </tr>
        @foreach($mgoods as $g)
          <tr>
            <td>{{ $g->mgoodscode }}</td>
            <td>{{ $g->mgoodsbarcode }}</td>
            <td>{{ $g->mgoodsname }}</td>
            <td>{{ $g->mgoodsalias }}</td>
            <td>{{ $g->mgoodstype }}</td>
            <td>{{ $g->mgoodsbrand }}</td>
            <td>{{ $g->mgoodsgroup1 }}</td>
            <td>{{ $g->mgoodsgroup2 }}</td>
            <td>{{ $g->mgoodsgroup3 }}</td>
            <td>{{ $g->mgoodsremark }}</td>
            <td>{{ $g->mgoodsunit }}</td>
            <td>{{ $g->mgoodsunit2 }}</td>
            <td>{{ $g->mgoodsunit3 }}</td>
            <td>{{ $g->mgoodssuppliercode }}</td>
            <td>{{ $g->mgoodssuppliername }}</td>
            <td>{{ $g->mgoodspricein }}</td>
            <td>{{ $g->mgoodspriceout }}</td>
            <td>{{ $g->mgoodscoapurchasing }}</td>
            <td>{{ $g->mgoodscoapurchasingname }}</td>
            <td>{{ $g->mgoodscoacogs }}</td>
            <td>{{ $g->mgoodscoacogsname }}</td>
            <td>{{ $g->mgoodscoaselling }}</td>
            <td>{{ $g->mgoodscoasellingname }}</td>
            <td>{{ $g->mgoodscoareturnofselling }}</td>
            <td>{{ $g->mgoodscoareturnofsellingname }}</td>
            <td>{{ $g->mgoodscogs }}</td>
            <td>{{ $g->mgoodsactive }}</td>
            <td>{{ $g->mgoodsuniquetransaction }}</td>
            <td>{{ $g->mgoodsbranches }}</td>
            <td>{{ $g->mgoodspicture }}</td>
            <td>{{ $g->mgoodsunit2convert }}</td>
            <td>{{ $g->mgoodsunit3convert }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
