<?php
namespace App\Helper;
use DB;
use App;
use Artisan;
use Auth;

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
