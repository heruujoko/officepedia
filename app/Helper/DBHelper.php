<?php
namespace App\Helper;
use DB;
use App;
use Artisan;
use Auth;
use App\MUser;
use App\UserBranch;

class DBHelper {

  public static function createNewDb($schemaName){
    DB::statement('CREATE DATABASE db_'.$schemaName);
  }

  public static function configureConnectionAndMigrate($tenantDB,$user){
    $config = App::make('config');
    $connections = $config->get('database.connections');
    $defaultConnection = $connections[$config->get('database.default')];
    $newConnection = $defaultConnection;
    // Override the database name.
    $newConnection['database'] = 'db_'.$tenantDB;
    // This will add our new connection to the run-time configuration for the duration of the request.
    App::make('config')->set('database.connections.db_'.$tenantDB, $newConnection);
    DBHelper::performMigration($tenantDB,$user);

    // add default branch
    $ub = new UserBranch;
    $ub->setConnection('db_'.$tenantDB);
    $ub->userid = $user->id;
    $ub->branchid = 1;
    $ub->save();

    // add to MUSER
    $mu = new MUser;
    $mu->setConnection('db_'.$tenantDB);
    $mu->musername = $user->name;
    $mu->museremail = $user->email;
    $mu->muserpass = $user->password;
    $mu->musercategory = 1;
    $mu->void = 0;
    $mu->defaultbranch = 1;
    $mu->roleid = 1;
    $mu->save();
  }

  public static function configureConnection($tenantDB){
    $config = App::make('config');
    $connections = $config->get('database.connections');
    $defaultConnection = $connections[$config->get('database.default')];
    $newConnection = $defaultConnection;
    // Override the database name.
    $newConnection['database'] = 'db_'.$tenantDB;
    // This will add our new connection to the run-time configuration for the duration of the request.
    App::make('config')->set('database.connections.db_'.$tenantDB, $newConnection);
  }

  public static function performMigration($tenantDB,$user){
    $config = App::make('config');
    $connections = $config->get('database.connections');
    // dd($connections);
    Artisan::call('migrate',['--database' => $connections['db_'.$tenantDB]['database'],'--force' => true]);
    Auth::attempt(['email' => $user->email,'password' => $user->password]);
    Artisan::call('db:seed');

    Auth::logout();
  }

}
