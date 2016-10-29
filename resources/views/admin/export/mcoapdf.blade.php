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
    <table class="table" style="font-size: 10px;">
      <tbody>
        <tr>
          <td><b>Grand Parent Code</b></td>
          <td><b>Grand Parent Name</b></td>
          <td><b>Parent Code</b></td>
          <td><b>Parent Name</b></td>
          <td><b>COA Code</b></td>
          <td><b>COA Name</b></td>
          <td><b>Saldo</b></td>
        </tr>
        @foreach($gparents as $gp)
          <tr>
            <td>{{ $gp->mcoagrandparentcode }}</td>
            <td>{{ $gp->mcoagrandparentname }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ number_format($gp->saldo,$decimals,$dec_point,$thousands_sep) }}</td>
          </tr>
          @foreach($gp->childs() as $parent)
            <tr>
              <td></td>
              <td></td>
              <td>{{ $parent->mcoaparentcode }}</td>
              <td>{{ $parent->mcoaparentname }}</td>
              <td></td>
              <td></td>
              <td>{{ number_format($parent->saldo,$decimals,$dec_point,$thousands_sep) }}</td>
            </tr>
            @foreach($parent->childs() as $mcoa)
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $mcoa->mcoacode }}</td>
                <td>{{ $mcoa->mcoaname }}</td>
                <td>{{ number_format($mcoa->saldo,$decimals,$dec_point,$thousands_sep) }}</td>
              </tr>
            @endforeach
          @endforeach
        @endforeach
      </tbody>
    </table>
    <div style="page-break-after: always;"></div>
  </body>
</html>
