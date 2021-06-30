<?php

namespace App\Http\Controllers\Gerencial;

use App\Budgets;
use App\Http\Controllers\Controller;
use Storage;
use File;
use Illuminate\Http\Request;

class BudgetController extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($contract) {
        $model = new Budgets();

        return view('gerencial.budget.index', ['contract' => $contract, 'budgets' => $model->where('contract_id', $contract)->get()]);
    }

    public function delete($id) {
        $objeto = (new Budgets())->find($id);
        $objeto->delete();
        session()->flash('sucesso', true);
        return redirect(url('/gerencial/budget/' . $objeto->contract_id . '/index'));
    }

    public function create($id = 0, int $contract) {
        $objeto = new Budgets();
        if ($id) {
            $objeto = $objeto->find($id);
        }
        return view('gerencial.budget.create', ['idcontract' => $contract, 'id' => $id, 'objeto' => $objeto]);
    }

    public function store($idcontract, $idantigo, Request $request) {
        $post = request()->all();
        $objeto = new Budgets();
        if ($idantigo) {
            $objeto = $objeto->find($idantigo);
        }
        if ($request->hasFile("arquivopdf")) {
            $md5 = md5(uniqid(rand(), true));
            $file = $request->file('arquivopdf');
            $nomePastaDestino = Storage::disk('public')->path('uploads/orcamentos');
            File::isDirectory($nomePastaDestino) or File::makeDirectory($nomePastaDestino, 0777, true, true);
            $novoNome = $md5 . '.' . $file->getClientOriginalExtension();
            $file->move(Storage::disk('public')->path('uploads/orcamentos'), $novoNome);
            $objeto->pathfile = $novoNome;
        }
        $objeto->linkpdf = $post['linkpdf'];
        $objeto->contract_id = $idcontract;
        $objeto->save();
        session()->flash('sucesso', true);
        return redirect(url("/gerencial/budget/" . $idcontract . "/index"));
    }

}
