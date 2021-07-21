<?php

namespace App\Http\Controllers;
use Auth;
use App\Budgets;
use App\Http\Controllers\Controller;
use Storage;
use File;
use Illuminate\Http\Request;

class BudgetController extends Controller {

    public function index() {
        $usuario=Auth::user()->userable;
        $model = new Budgets();
      
        return view('portal.budgets.index', ['budgets' => $model->where('contract_id', $usuario->contract_id)->get()]);
    }

  
    public function see($id = 0) {
        $usuario=Auth::user()->userable;
        $objeto = new Budgets();
        if ($id) {
            $objeto = $objeto->where('id',$id)->where('contract_id',$usuario->contract_id)->first();
        }
        return view('portal.budgets.see', ['objeto' => $objeto]);
    }


}
