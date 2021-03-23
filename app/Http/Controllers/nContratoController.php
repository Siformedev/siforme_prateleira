<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class nContratoController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('c')){
            $code = $request->get('c');
        }else{
            $code = null;
        }
        return view('adesao.ncontrato', compact('code'));
    }

    public function consultContract(Request $request)
    {
        $code = $request->input('code');
        $contrato = Contract::where('code', $code)->get()->first();
        if(isset($contrato->valid) and !empty($contrato->valid)){
            $request->session()->flush();
            $request->session()->put(['date_inicio' => date('Y-m-d H:i:s')]);
            $request->session()->put(['contrato' => ['code' => $contrato->code, 'valid' => $contrato->valid]]);
            $request->session()->save();
            Session('teste.id', '1');
            return redirect('adesao/contrato');

        }else{
            \Session::flash('flash_message','Codigo não localizado');
            return redirect('adesao/ncontrato');
        }
        //dd($request->all());
        //return view('adesao.ncontrato');
    }
}
