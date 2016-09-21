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
    .tree li:before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: -11px;
        width: 1px;
        -webkit-transition: "border-color 0.1s ease 0.1s";
        -moz-transition: "border-color 0.1s ease 0.1s";
        -o-transition: "border-color 0.1s ease 0.1s";
        transition: "border-color 0.1s ease 0.1s";
    }
    .tree li:after {
        border-top: 1px solid #999 !important;
        height: 20px;
        top: 18px;
        width: 25px;
    }
    .tree li:after, .tree li:before {
        content: '';
        left: -20px;
        position: absolute;
        right: auto;
    }
    .tree>ul>li:after, .tree>ul>li:before {
        border: 0;
    }
    .tree li:last-child:before {
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
        </tr>
        @foreach($gparents as $gp)
          <tr>
            <td>{{ $gp->mcoagrandparentcode }}</td>
            <td>{{ $gp->mcoagrandparentname }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          @foreach($gp->childs() as $parent)
            <tr>
              <td></td>
              <td></td>
              <td>{{ $parent->mcoaparentcode }}</td>
              <td>{{ $parent->mcoaparentname }}</td>
              <td></td>
              <td></td>
            </tr>
            @foreach($parent->childs() as $mcoa)
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $mcoa->mcoacode }}</td>
                <td>{{ $mcoa->mcoaname }}</td>
              </tr>
            @endforeach
          @endforeach
        @endforeach
      </tbody>
    </table>
    <!-- <div style="page-break-after: always;"></div>
    <h3> Master Akun </h3>
    <div class="tree smart-form container" id="mcoatree" style="font-size: 12px;">
      <ul role="tree">
        @foreach($gparents as $gp)
        <li class="parent_li" role="treeitem">
          <span title="Collapse this branch"><i class="fa fa-lg fa-folder-open"></i> <b>{{ $gp->mcoagrandparentcode }}</b> {{ $gp->mcoagrandparentname }}</span>
          <ul role="group">
            @foreach($gp->childs() as $parent)
            <li class="parent_li" role="treeitem">
              <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $parent->mcoaparentcode }}</b> {{ $parent->mcoaparentname }}</span>
              <ul role="group">
                <li style="display:none">
                  <span title="Collapse this branch" class="addtree" onclick="addcoa('{{ $parent->mcoaparentcode }}','{{ $parent->mcoaparenttype}}')"><i class="fa fa-lg fa-plus-circle"></i> <b>Add New</b></span>
                </li>
                @foreach($parent->childs() as $coa)
                <li>
                  <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $coa->mcoacode }}</b> {{ $coa->mcoaname }}</span>
                </li>
                @endforeach
              </ul>
            </li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div> -->
    <br>
  </body>
</html>
