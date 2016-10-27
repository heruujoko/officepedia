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
          <td><b>ID Karyawan</b></td>
          <td><b>Sapaan</b></td>
          <td><b>Nama Karyawan</b></td>
          <td><b>Posisi</b></td>
          <td><b>Level</b></td>
          <td><b>HP</b></td>
          <td><b>Telfon</b></td>
          <td><b>Pin BBM</b></td>
          <td><b>No KTP</b></td>
          <td><b>Kota</b></td>
          <td><b>Kode Pos</b></td>
          <td><b>Provinsi</b></td>
          <td><b>Negara</b></td>
          <td><b>Keterangan</b></td>
        </tr>
        @foreach($memployee as $ct)
          <tr>
            <td>{{ $ct->memployeeid }}</td>
            <td>{{ $ct->memployeetitle }}</td>
            <td>{{ $ct->memployeename }}</td>
            <td>{{ $ct->memployeeposition }}</td>
            <td>{{ $ct->level->level }}</td>
            <td>{{ $ct->memployeephone }}</td>
            <td>{{ $ct->memployeehomephone }}</td>
            <td>{{ $ct->memployeebbmpin }}</td>
            <td>{{ $ct->memployeeidcard }}</td>
            <td>{{ $ct->memployeecity }}</td>
            <td>{{ $ct->memployeezipcode }}</td>
            <td>{{ $ct->memployeeprovince }}</td>
            <td>{{ $ct->memployeecountry }}</td>
            <td>{{ $ct->memployeeinfo }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
