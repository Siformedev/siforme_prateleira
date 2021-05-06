<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Mail\Registered;
use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CadastroController extends Controller
{

    public function contrato(Request $request, $codturma)
    {
        $title = env('APP_NAME')." - Código da turma";
        $contract = Contract::where('code', $codturma)->first();
        if(!$contract){
            $request->session()->flash('error', 'Código contrato não localizado');
            return redirect()->route('cad.ncontrato');
        }
        $courses = $contract->courses()->pluck('name' , 'id');
        $courses_select = [];
        $courses->toArray();
        $courses_select[0] = "Selecione o curso";
        foreach ($courses as $id => $course){
            $courses_select[$id] = $course;
        }


        //dd($contract, $courses);

        return view('cadastro.contrato', compact('contract', 'courses_select', 'title'));
    }

    public function store(Request $request){

        $title = env('APP_NAME');

        $contract_id = $request->segment(2);

        $contract_ = Contract::where('code', $contract_id)->get(['id'])->first();

        $this->validate($request, [
            "course" => "required|int|min:1",
            "name" => "required",
            "cpf" => "required",
            "email" => "required",
            "cellphone" => "required",
            "intention" => "required|int|min:1"
        ]);

        $req = $request->all();
        unset($req['_token']);
        $req['cpf'] = str_replace(".", "", str_replace("-", "", $req['cpf']));

        $ver = Register::where('cpf', $req['cpf'])->orWhere('email', $req['email'])->get();
        if($ver->count() > 0){
            return view('cadastro.jacadastrado', compact('contract_id', 'title'));
        }

        $req['contract_id'] = $contract_->id;


        if($reg = Register::create($req)){
            Mail::to($reg->email)->send(new Registered());
            return view('cadastro.cadastradoefetuado', compact('contract_id', 'title'));
        }else{
            return view('cadastro.erro', compact('contract_id', 'title'));
        };



    }

    public function nContrato(Request $request){

        $title = env('APP_NAME')." - Código da turma";

        $cod = $request->get('cod');
        $error = $request->session()->get('error');
        if($cod){
            return redirect()->route('cad.contrato', ['codturma' => $cod]);
        }
        return view('cadastro.ncontrato', compact('error', 'title'));
    }

    public function cpf(Request $request){

        $title = env('APP_NAME')." - Digite seu CPF";
        $error = $request->session()->get('error');
        return view('cadastro.ncpf', compact('title', 'error'));
    }

    public function cpfValid(Request $request){

        $title = env('APP_NAME')." - Buscando CPF";
        $this->validate($request, [
            "cpf" => "required"
        ]);


        $cpf = $request->get('cpf');
        if($cpf){

            $cpf = str_replace(".", "", str_replace("-", "", $cpf));

            $cpfValid = Register::where('cpf', $cpf)->get()->first();
            if(isset($cpfValid) && $cpfValid->count() > 0){

                $contrato = Contract::find($cpfValid->contract_id);
                if(isset($contrato->valid) and !empty($contrato->valid)){
                    $request->session()->flush();
                    $request->session()->put(['register' => $cpfValid->toArray()]);
                    $request->session()->put(['date_inicio' => date('Y-m-d H:i:s')]);
                    $request->session()->put(['contrato' => ['code' => $contrato->code, 'valid' => $contrato->valid]]);
                    $request->session()->save();
                    Session('teste.id', '1');
                    return redirect('adesao/contrato');

                }else{
                    $request->session()->flash('error', 'Erro!!');
                    return redirect()->route('cad.cpf');
                }

            }else{
                $request->session()->flash('error', 'CPF não localizado na lista de PRÉ CADASTRO');
                return redirect()->route('cad.cpf');
            }

        }

    }

}
