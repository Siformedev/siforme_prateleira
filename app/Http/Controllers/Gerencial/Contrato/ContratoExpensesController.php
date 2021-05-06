<?php

namespace App\Http\Controllers\Gerencial\Contrato;

use App\Contract;
use App\ContractExpenses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContratoExpensesController extends Controller
{
    /**
     * @var Contract
     */
    private $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function index($contract, Request $request)
    {
        $contract = $this->contract->find($contract);

        $download = $request->get('download');
        if($download == 'billing_file' || $download == 'payment_file'){
            $expense = $request->get('expense');
            $expense = ContractExpenses::find($expense);
            return $this->download($expense, $download);
        }


        $expenses = $contract->expenses;
        $sum['total'] = $expenses->sum('value');
        $paids = $expenses->groupBy('paid');
        $sum['paid'] = 0;
        $sum['not_paid'] = 0;
        if(isset($paids[1])){
            $sum['paid'] = $paids[1]->sum('value');
        }
        if(isset($paids[0])){
            $sum['not_paid'] = $paids[0]->sum('value');
        }



        return view('gerencial.contrato.expenses.index', compact('contract', 'sum'));
    }

    public function create()
    {
        return view('gerencial.contrato.expenses.create');
    }

    public function store($contract, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['value'] = str_replace(",", ".", str_replace(".", "", $data['value']));
        $ext_valids = ['pdf', 'zip', 'jpg', 'jpeg', 'png'];

        $validator = Validator::make($data, [
            'value' => 'required|numeric|min:1',
            'category_id' => 'required|numeric|min:1',
            'name' => 'required|max:50',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect(route('gerencial.contrato.expenses.create', ['contract' => $contract]))
                ->withErrors($validator)
                ->withInput();
        }


        if ($request->file('billing_file')) {
            $ext = $request->billing_file->extension();
            if(!in_array($ext, $ext_valids)){
                \Session::flash("msg_error", "Arquivo de pagamento com formato incorreto! <br> Permitido somente formatos: 'pdf', 'zip', 'jpg', 'jpeg' e 'png'");
                return redirect()->back()->withInput();
            }
            $billing_file = $request->file('billing_file')->store('anexos/contratosexpenses');
        }

        if ($request->file('payment_file')) {
            $ext = $request->payment_file->extension();
            if(!in_array($ext, $ext_valids)){
                \Session::flash("msg_error", "Arquivo de pagamento com formato incorreto! <br> Permitido somente formatos: 'pdf', 'zip', 'jpg', 'jpeg' e 'png'");
                return redirect()->back()->withInput();
            }
            $payment_file = $request->file('payment_file')->store('anexos/contratosexpenses');
        }


        $data['contract_id'] = $contract;
        @$data['billing_file'] = $billing_file;
        @$data['payment_file'] = $payment_file;
        $expenses = ContractExpenses::create($data);
        \Session::flash("msg_success", "Depesa registrada com sucesso!");
        return redirect()->route('gerencial.contrato.expenses', ['contract' => $contract]);
    }

    public function edit(Request $request, Contract $contract, ContractExpenses $expenses)
    {
        $remove = $request->get('remove');
        if(!empty($remove) && ($remove == 'billing_file' || $remove == 'payment_file')){

            if(File::delete(storage_path('app/'.$expenses->$remove))){
                $expenses->$remove = "";
                $expenses->save();
            }
        }

        $download = $request->get('download');
        if(!empty($download) && ($download == 'billing_file' || $download == 'payment_file')){

            return $this->download($expenses, $download);
        }

        return view('gerencial.contrato.expenses.edit', compact('contract', 'expenses'));
    }

    public function update($contract, ContractExpenses $expenses, Request $request)
    {
        $ext_valids = ['pdf', 'zip', 'jpg', 'jpeg', 'png'];
        $data = $request->all();
        unset($data['_token']);
        $data['value'] = str_replace(",", ".", str_replace(".", "", $data['value']));

        $validator = Validator::make($data, [
            'value' => 'required|numeric|min:1',
            'name' => 'required|max:50',
            'category_id' => 'required|numeric|min:1',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect(route('gerencial.contrato.expenses.edit', ['contract' => $contract, 'expenses' => $expenses->id]))
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->file('billing_file')) {
            $ext = $request->billing_file->extension();
            if(!in_array($ext, $ext_valids)){
                \Session::flash("msg_error", "Arquivo de pagamento com formato incorreto! <br> Permitido somente formatos: 'pdf', 'zip', 'jpg', 'jpeg' e 'png'");
                return redirect()->back()->withInput();
            }
            $billing_file = $request->file('billing_file')->store('anexos/contratosexpenses');
            $data['billing_file'] = $billing_file;
        }

        if ($request->file('payment_file')) {
            $ext = $request->payment_file->extension();
            if(!in_array($ext, $ext_valids)){
                \Session::flash("msg_error", "Arquivo de pagamento com formato incorreto! <br> Permitido somente formatos: 'pdf', 'zip', 'jpg', 'jpeg' e 'png'");
                return redirect()->back()->withInput();
            }
            $payment_file = $request->file('payment_file')->store('anexos/contratosexpenses');
            $data['payment_file'] = $payment_file;
        }

        unset($data['_token']);
        $expenses->update($data);
        \Session::flash("msg_success", "Depesa editada com sucesso!");
        return redirect()->route('gerencial.contrato.expenses', ['contract' => $contract]);
    }

    public function remove($contract, ContractExpenses $expenses)
    {
        if(!empty($expenses->billing_file)){
            if(File::exists(storage_path('app/'.$expenses->billing_file))){
                File::delete(storage_path('app/'.$expenses->billing_file));
            }
        }

        if(!empty($expenses->payment_file)){
            if(File::exists(storage_path('app/'.$expenses->payment_file))){
                File::delete(storage_path('app/'.$expenses->payment_file));
            }

        }

        $expenses->delete();
        \Session::flash("msg_success", "Depesa removida com sucesso!");
        return redirect()->route('gerencial.contrato.expenses', ['contract' => $expenses->contract_id]);
    }

    private function download($expenses, $doc)
    {
        $file_extension = File::extension($expenses->$doc);
        $filename = str_slug($expenses->name)."-".$doc.".".$file_extension;
        return response()->download(storage_path('app/'.$expenses->$doc), $filename);
    }


}
