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
          <td><b>ID Pelanggan</b></td>
          <td><b>Nama Pelanggan</b></td>
          <td><b>Email</b></td>
          <td><b>Telpon Kantor</b></td>
          <td><b>Fax</b></td>
          <td><b>Website</b></td>
          <td><b>Alamat</b></td>
          <td><b>Kota</b></td>
          <td><b>Kode Pos</b></td>
          <td><b>Provinsi</b></td>
          <td><b>Negara</b></td>
          <td><b>Nama Kontak</b></td>
          <td><b>Jabatan</b></td>
          <td><b>Email Kontak</b></td>
          <td><b>Handphone</b></td>
        </tr>
        @foreach($customer as $ct)
          <tr>
            <td>{{ $ct->mcustomerid }}</td>
            <td>{{ $ct->mcustomername }}</td>
            <td>{{ $ct->mcustomeremail }}</td>
            <td>{{ $ct->mcustomerphone }}</td>
            <td>{{ $ct->mcustomerfax }}</td>
            <td>{{ $ct->mcustomerwebsite }}</td>
            <td>{{ $ct->mcustomeraddress }}</td>
            <td>{{ $ct->mcustomercity }}</td>
            <td>{{ $ct->mcustomerzipcode }}</td>
            <td>{{ $ct->mcustomerprovince }}</td>
            <td>{{ $ct->mcustomercountry }}</td>
            <td>{{ $ct->mcustomercontactname }}</td>
            <td>{{ $ct->mcustomercontactposition }}</td>
            <td>{{ $ct->mcustomercontactemail }}</td>
            <td>{{ $ct->mcustomercontactemailphone }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
