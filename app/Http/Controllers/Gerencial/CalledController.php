<?php

namespace App\Http\Controllers\Gerencial;

use App\AuditAndLog;
use App\Chamado;
use App\Forming;
use App\Http\Controllers\Controller;
use App\Mail\ChamadoRespondido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CalledController extends Controller
{
    public function calleds()
    {
        $chamados_abertos = Chamado::where('status', '=', 1)->orderBy('updated_at', 'asc')->get()->toArray();
        $chamados_finalizados = Chamado::where('status', '=', 2)->orderBy('updated_at', 'desc')->get()->toArray();
        $chamados_aguardresp = Chamado::where('status', '=', 6)->orderBy('updated_at', 'desc')->get()->toArray();
        return view('gerencial.calleds', compact('chamados_abertos', 'chamados_finalizados', 'chamados_aguardresp'));
    }

    public function calledShow(Chamado $chamado)
    {
        $forming = Forming::find($chamado->forming_id);
        return view('gerencial.chamados_show', compact('chamado', 'forming'));
    }

    public function calledConversationsStore(Request $request, Chamado $chamado)
    {
        $dataDb = $request->all();
        $dataDb['user_id'] = \auth()->user()->id;
        $chamado->conversas()->create($dataDb);
        $chamado->status = '6';
        $chamado->save();
        Mail::to($chamado->forming->email)->send(new ChamadoRespondido($chamado, $dataDb['texto']));
        return redirect()->route('gerencial.called.show', ['chamado' => $chamado->id]);

    }
}
