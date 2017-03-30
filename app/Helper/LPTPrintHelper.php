<?php

namespace App\Helper;
use App\Helper\ArrayToTextTable;

class LPTPrintHelper {

  public static function toTextPage($data){

      $decimals = $data['decimals'];
      $dec_point = $data['dec_point'];
      $thousands_sep = $data['thousands_sep'];
      $html = "";
      $page =0 ;
      $isLastPage = false;

      foreach($data['chunks'] as $c){
        $page++;
        if($page == sizeof($data['chunks'])){
          $isLastPage = true;
        }
        $html .= "".$data['config']->msyscompname."\t\t\t\t\t\t\t\t\t\t"."NOTA PENJUALAN"."\t\n";

        $addr = explode(" ",$data['config']->msyscompaddress);
        $addrwords = sizeof($addr);
        $html .= "".$data['config']->msyscompaddress;
        if($addrwords > 1){
          for($l=0;$l<(13-$addrwords);$l++){
            $html .= "\t";
          }
        } else {
          $html .= "\t\t\t\t\t\t\t\t\t\t\t";
        }

        $html .= "No Faktur "."\t".$data['invoice']->mhinvoiceno."\n";
        $html .= "\t\t\t\t\t\t\t\t\t\t\t"."Tanggal Faktur "."\t".$data['invoice']->mhinvoicedate."\n";
        $html .= "\t\t\t\t\t\t\t\t\t\t\t"."Jatuh Tempo "."\t".$data['invoice']->mhinvoiceduedate."\n";
        $html .= "\t\t\t\t\t\t\t\t\t\t\t"."Tanggal Order "."\t".$data['invoice']->mhinvoicedate."\n";
        $html .= "Kepada Yth:\t\t\t\t\t\t\t\t\t\t"."User "."\t".$data['user']->id." ".$data['user']->name."\n";
        $html .= $data['invoice']->mhinvoicecustomername."\t\t\t\t\t\t\t\t\t\t\t"."Divisi "."\t\n";
        $html .= "\t\t\t\t\t\t\t\t\t\t\t"."No PO "."\t\n";
        $html .= "\t\t\t\t\t\t\t\t\t\t\t"."No Proforma "."\t";

        $rows = [];
        $rows[0] = [
          'Kode','Nama Produk','Jumlah','Multi Satuan','Harga Jual','Subtotal','Diskon'
        ];

        foreach ($c['details'] as $d) {
          $r = [
            $d->mhinvoiceno,$d->mdinvoicegoodsid." - ".$d->mdinvoicegoodsname,$d->mdinvoicegoodsqty,$d['qty_label'],number_format($d->mdinvoicegoodsprice,$decimals,$dec_point,$thousands_sep),number_format($d->mdinvoicegoodsgrossamount,$decimals,$dec_point,$thousands_sep),number_format($d->mdinvoicegoodsdiscount,$decimals,$dec_point,$thousands_sep)
          ];
          array_push($rows,$r);
        }

        if(sizeof($c['details']) < 20){

          if($isLastPage){
            $dummyLine = [
              '','','','','','',''
            ];

            for($dl=0;$dl<(20-sizeof($c['details']));$dl++){
              array_push($rows,$dummyLine);
            }
          } else {
            $dummyLine = [
              '','','','','','',''
            ];

            for($dl=0;$dl<(30-sizeof($c['details']));$dl++){
              array_push($rows,$dummyLine);
            }
          }

        }

        $totalPage = [
            '# '.sizeof($data['chunks'][0]['details'])." items",'','','','Total',number_format($data['chunks'][0]['chunk_subtotal'],$decimals,$dec_point,$thousands_sep),''
        ];
        array_push($rows,$totalPage);

        $att = new ArrayToTextTable($rows,$data['offset']);
        $html .= "\n".$att->render()."\n";

        if($isLastPage){
            $html .= "Cap dan tanda-tangan:"."\t\t\t\t\t\t"."Jumlah "."\t\t\t\t\t".number_format($data['invoice']->mhinvoicesubtotal,$decimals,$dec_point,$thousands_sep)."\t\n";
            $html .= ""."\t\t\t\t\t\t\t\t"."Discount"."\t\t\t\t".number_format($data['invoice']->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep)."\t\n";
            $html .= ""."\t\t\t\t\t\t\t\t"."Dasar Pengenaan Pajak"."\t\t\t".number_format($data['invoice']->mhinvoicesubtotal - $data['invoice']->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep)."\t\n";
            $html .= "\t\t\t\t\t\t\t\t"."PPn 10 %"."\t\t\t\t".number_format($data['invoice']->mhinvoicetaxtotal - $data['invoice']->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep)."\t\n";
            $html .= "\n\n\n(.............................) (.............................)"."\tTOTAL"."\t\t\t\t\t"."".number_format($data['invoice']->mhinvoicegrandtotal,$decimals,$dec_point,$thousands_sep)."\n";
            $html .= "\t"."Toko / Pembeli"."\t\t\t"."   Otorisasi\n";
            $html .= $data['footnote']."\t\tTerbilang ".$data['terbilang']."\n";
        }

        $html .= "\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t"."halaman ke ".$page." dari ".sizeof($data['chunks']);
      }

      return $html;

  }

}
