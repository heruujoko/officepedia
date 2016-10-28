<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoods14digitProc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE PROCEDURE `autogengoods`(IN `tablename` VARCHAR(255), IN `prefixcol` VARCHAR(255), IN `prefixcountcol` INT(15), IN `targetcol` VARCHAR(255), IN `targetrow` VARCHAR(255)) NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN
  IF (prefixcountcol < 10) THEN
  SET @newprefix = CONCAT(prefixcol,'0000000000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 100) THEN
  SET @newprefix = CONCAT(prefixcol,'000000000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 1000) THEN
  SET @newprefix = CONCAT(prefixcol,'00000000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 10000) THEN
  SET @newprefix = CONCAT(prefixcol,'0000000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 100000) THEN
  SET @newprefix = CONCAT(prefixcol,'000000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 1000000) THEN
  SET @newprefix = CONCAT(prefixcol,'00000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 10000000) THEN
  SET @newprefix = CONCAT(prefixcol,'0000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 100000000) THEN
  SET @newprefix = CONCAT(prefixcol,'000',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 1000000000) THEN
  SET @newprefix = CONCAT(prefixcol,'00',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 10000000000) THEN
  SET @newprefix = CONCAT(prefixcol,'0',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 100000000000) THEN
  SET @newprefix = CONCAT(prefixcol,'',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  END IF;
  PREPARE update_stmt FROM @autogen_query;
  EXECUTE update_stmt;
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
