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
  SET @newprefix = CONCAT(prefixcol,'00',prefixcountcol);
  SET @autogen_query = CONCAT('UPDATE ',tablename,' SET ',targetcol,' = \"',@newprefix,'\" WHERE ',tablename,'.id = ',targetrow);
  ELSEIF (prefixcountcol < 100) THEN
  SET @newprefix = CONCAT(prefixcol,'0',prefixcountcol);
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
