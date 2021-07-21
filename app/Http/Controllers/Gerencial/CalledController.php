<?php

namespace App\Http\Controllers\Gerencial;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\ChamadoRespondido;
use App\Chamado;
use App\Forming;



class CalledController extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function calleds() {
        $chamados_abertos = Chamado::where('status', '=', 1)->orderBy('updated_at', 'asc')->get()->toArray();
        $chamados_finalizados = Chamado::where('status', '=', 2)->orderBy('updated_at', 'desc')->get()->toArray();
        $chamados_aguardresp = Chamado::where('status', '=', 6)->orderBy('updated_at', 'desc')->get()->toArray();
        return view('gerencial.calleds', compact('chamados_abertos', 'chamados_finalizados', 'chamados_aguardresp'));
    }

    public function calledShow(Chamado $chamado) {
        $forming = Forming::find($chamado->forming_id);
        return view('gerencial.chamados_show', compact('chamado', 'forming'));
    }

    public function calledConversationsStore(Request $request, Chamado $chamado) {
        $dataDb = $request->all();
        $dataDb['user_id'] = \auth()->user()->id;
        $chamado->conversas()->create($dataDb);
        $chamado->status = '6';
        $chamado->save();
        Mail::to($chamado->forming->email)->send(new ChamadoRespondido($chamado, $dataDb['texto']));
        return redirect()->route('gerencial.called.show', ['chamado' => $chamado->id]);
    }

}
