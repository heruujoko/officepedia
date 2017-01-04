<html>
  <head>
    <style>
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
    <h3 style="text-align:center">Invoice Pembelian</h3>  
    <table class="table" style="font-size: 10px;width: 100%;">
      <tbody>
        <tr>
          <td><b>Nomor Invoice</b></td>
          <td><b>Supplier</b></td>
          <td><b>Tanggal</b></td>
          <td><b>Jatuh Tempo</b></td>
          <td><b>Subtotal</b></td>
          <td><b>Pajak</b></td>
          <td><b>Diskon</b></td>
          <td><b>Total</b></td>
        </tr>
        @foreach($purchases as $p)
          <tr>
            <td>{{ $p->mhpurchasequotationno }}</td>
            <td>{{ $p->mhpurchasequotationsuppliername }}</td>
            <td>{{ $p->mhpurchasequotationdate }}</td>
            <td>{{ $p->mhpurchasequotationduedate }}</td>
            <td>{{ number_format($p->mhpurchasequotationsubtotal,$decimals,$dec_point,$thousands_sep) }}</td>
            <td>{{ number_format($p->mhpurchasequotationtaxtotal,$decimals,$dec_point,$thousands_sep) }}</td>
            <td>{{ number_format($p->mhpurchasequotationdiscounttotal,$decimals,$dec_point,$thousands_sep) }}</td>
            <td>{{ number_format($p->mhpurchasequotationgrandtotal,$decimals,$dec_point,$thousands_sep) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
