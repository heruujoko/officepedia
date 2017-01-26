<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use Auth;
use App\Role;
use PDF;
use Excel;

class RoleController extends Controller
{
    public function index(){
        $data['section'] = "Hak Akses";
        $data['active'] = "roles";
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.roles',$data);
    }

    public function roles_print(){
        $data['roles'] = Role::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->get();
        return view('admin.export.roles',$data);
    }

    public function roles_pdf(){
        $data['roles'] = Role::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->get();
        $pdf = PDF::loadview('admin/export/roles',$data);
        return $pdf->setPaper('a4', 'potrait')->download('Roles.pdf');
    }

    public function roles_excel(){
        $this->data['roles'] = Role::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->get();
        $this->count = 0;
        return Excel::create('Roles',function($excel){
			$excel->sheet('Roles',function($sheet){
				$this->count++;
                $sheet->row($this->count,array(
                    'No','Nama','Dibuat'
                ));
                foreach($this->data['roles'] as $h){
                    $this->count++;

                    $sheet->row($this->count,array(
                        $this->count,
                        $h->name,
                        $h->created_at
                    ));

                }
			});
		})->export('xls');
    }

    public function roles_csv(){
        $this->data['roles'] = Role::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->get();
        $this->count = 0;
        return Excel::create('Roles',function($excel){
			$excel->sheet('Roles',function($sheet){
				$this->count++;
                $sheet->row($this->count,array(
                    'No','Nama','Dibuat'
                ));
                foreach($this->data['roles'] as $h){
                    $this->count++;

                    $sheet->row($this->count,array(
                        $this->count,
                        $h->name,
                        $h->created_at
                    ));

                }
			});
		})->export('csv');
    }
}
