<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMcustomerProc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE PROCEDURE `autogenmcustomer`(IN `newrow` INT(10)) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN
  	DECLARE prfx VARCHAR(10);
    DECLARE cnt INTEGER(10);
    DECLARE last_cnt VARCHAR(10);

    SELECT msysprefixcustomer INTO prfx FROM mconfig where mconfig.id = 1;
	SELECT COUNT(*) INTO cnt FROM mcustomer;
    IF (cnt < 10) THEN UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'00000',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('00000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100) THEN
    UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'0000',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('0000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000) THEN
    UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'000',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 10000) THEN
    UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'00',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('00',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100000) THEN
    UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'0',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('0',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000000) THEN
    UPDATE mcustomer SET mcustomerid = CONCAT(prfx,'',cnt) WHERE mcustomer.id = newrow;
    UPDATE mconfig SET msysprefixcustomercount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixcustomerlastcount = CONCAT('',cnt) WHERE mconfig.id = 1;
    END IF;
  END
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
