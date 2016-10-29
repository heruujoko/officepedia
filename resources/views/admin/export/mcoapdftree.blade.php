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
    <h3> Master Akun </h3>
    <div class="tree smart-form container" id="mcoatree" style="font-size: 12px;">
      <ul role="tree">
        @foreach($gparents as $gp)
        <li class="parent_li" role="treeitem">
          <span title="Collapse this branch"><i class="fa fa-lg fa-folder-open"></i> <b>{{ $gp->mcoagrandparentcode }}</b> {{ $gp->mcoagrandparentname }} / Rp. {{ $gp->saldo }}</span>
          <ul role="group">
            <?php $cp =0 ?>
            @foreach($gp->childs() as $parent)
            <?php $cp++ ?>
            <li class="parent_li" role="treeitem">
              @if($cp == count($gp->childs()))
              <div class="bfr lc"></div>
              @else
              <div class="bfr"></div>
              @endif
              <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $parent->mcoaparentcode }}</b> {{ $parent->mcoaparentname }} / Rp. {{ $parent->saldo }}</span>
              <ul role="group">
                @foreach($parent->childs() as $coa)
                <li>
                  <div class="bfr lc"></div>
                  <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $coa->mcoacode }}</b> {{ $coa->mcoaname }} / Rp. {{ $coa->saldo }}</span>
                  <div class="aftr"></div>
                </li>
                @endforeach
              </ul>
              <div class="aftr"></div>
            </li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div>
    <br>
  </body>
</html>
