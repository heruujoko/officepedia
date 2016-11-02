<?php
namespace App\Helper;
use DB;
use App;
use Artisan;
use Auth;

class DBHelper {

  public static function createNewDb($schemaName,$user){
    DB::statement('CREATE DATABASE db_'.$schemaName);
  }

  public static function configureConnectionAndMigrate($tenantDB){
    $config = App::make('config');
    $connections = $config->get('database.connections');
    $defaultConnection = $connections[$config->get('database.default')];
    $newConnection = $defaultConnection;
    // Override the database name.
    $newConnection['database'] = 'db_'.$tenantDB;
    // This will add our new connection to the run-time configuration for the duration of the request.
    App::make('config')->set('database.connections.db_'.$tenantDB, $newConnection);
    Auth::attempt(['email' => $user->email,'password' => $user->password]);
    DBHelper::performMigration($tenantDB);
    Auth::logout();
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

  public static function performMigration($tenantDB){
    $config = App::make('config');
    $connections = $config->get('database.connections');
    // dd($connections);
    Artisan::call('migrate',['--database' => $connections['db_'.$tenantDB]['database'],'--force' => true]);
    Artisan::call('db:seed');
  }

}
