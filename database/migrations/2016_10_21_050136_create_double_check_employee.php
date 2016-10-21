<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDoubleCheckEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE PROCEDURE `finduniqueemployee`(IN `newrow` INT(10), IN `cnt` INT(10)) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN
  	DECLARE prfx VARCHAR(10);
    DECLARE last_cnt VARCHAR(10);

    SELECT msysprefixemployee INTO prfx FROM mconfig where mconfig.id = 1;
    IF (cnt < 10) THEN UPDATE memployee SET memployeeid = CONCAT(prfx,'00000',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('00000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100) THEN
    UPDATE memployee SET memployeeid = CONCAT(prfx,'0000',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('0000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000) THEN
    UPDATE memployee SET memployeeid = CONCAT(prfx,'000',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('000',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 10000) THEN
    UPDATE memployee SET memployeeid = CONCAT(prfx,'00',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('00',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 100000) THEN
    UPDATE memployee SET memployeeid = CONCAT(prfx,'0',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('0',cnt) WHERE mconfig.id = 1;
    ELSEIF (cnt < 1000000) THEN
    UPDATE memployee SET memployeeid = CONCAT(prfx,'',cnt) WHERE memployee.id = newrow;
    UPDATE mconfig SET msysprefixemployeecount = cnt WHERE mconfig.id = 1;
    UPDATE mconfig SET msysprefixemployeelastcount = CONCAT('',cnt) WHERE mconfig.id = 1;
    END IF;
  END");
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
