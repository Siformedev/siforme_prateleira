<?php

namespace App\Http\Controllers\Gerencial;

use App\Contract;
use App\ContractCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ContratoController extends Controller
{
    /**
     * @var Contract
     */
    private $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function create()
    {
        return view('gerencial.contrato.create');
    }

    public function index()
    {
        return view('gerencial.contrato.index', ['contracts' => $this->contract->get()->toArray()]);
    }

    public function store(Request $request)
    {

        //$curso->contracts(1,33);

        //die($curso->contracts());

        //dd($request->all());
        $this->validate($request, [
            "name" => "required",
            "institution" => "required",
            "conclusion_year" => "required",
            "conclusion_month" => "required",
            "signature_date" => "required",
            "birthday_date" => "required",
            "igpm" => "required",
            "email" => "required|email",
            "code" => "required|unique:contracts,code",
            "goal" => "required",
            "pseg_acc" => "required",
            "periodos" => "required",
            "course" => "required",
        ]);

        $data = $request->all();
        $data['periodos'] = implode(',', $data['periodos']);
        $data['valid'] = str_random(18);
        unset($data['_token']);

        DB::beginTransaction();        
        try {
            
            $contrato = $this->contract->create($data);
            $c = new ContractCourse();
            $c->contract_id = $contrato->id;
            $c->course_id = $data['course'];
            $c->save();
            
            DB::commit();

            Alert::success('Sucesso', 'Foi cadastrado o contrato ' . $contrato->name . '. Agora você pode cadastrar os produtos associados ao mesmo.');
            return redirect()->route('gerencial.contrato.admin.prod.create', $contrato->id);
        } catch (\Exception $e) {            
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function edit(Contract $contract)
    {
        return view('gerencial.contrato.edit', ['contract' => $contract]);
    }

    public function update(Request $request, Contract $contract)
    {
        $this->contract = $contract;
        $this->validate($request, [
            "name" => "required",
            "institution" => "required",
            "conclusion_year" => "required",
            "conclusion_month" => "required",
            "signature_date" => "required",
            "birthday_date" => "required",
            "igpm" => "required",
            "email" => "required|email",
            "code" => "required|unique:contracts,code," . $this->contract->id,
        ]);
        $data = $request->all();
        unset($data['_token']);
        $this->contract->update($data);
        $request->session()->flash('message', 'O contrato ' . $data['name'] . ' foi atualizado com sucesso!');
        return redirect()->route('gerencial.contratos');
    }
}
