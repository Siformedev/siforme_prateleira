<?php

namespace App\Http\Controllers\Gerencial;

use App\Brindes;
use App\Http\Controllers\Controller;
use Storage;
use File;
use Illuminate\Http\Request;

class BrindesController extends Controller {

    public function index($contract) {
        $model = new Brindes();
      
        return view('gerencial.brindes.index', ['contract' => $contract, 'budgets' => $model->where('contract_id', $contract)->get()]);
    }

    public function delete($id) {
        $objeto = (new Brindes())->find($id);
        $objeto->delete();
        session()->flash('sucesso', true);
        return redirect(url('/gerencial/brindes/' . $objeto->contract_id . '/index'));
    }

    public function create($id = 0, int $contract) {
        $objeto = new Brindes();
        if ($id) {
            $objeto = $objeto->find($id);
        }
        return view('gerencial.brindes.create', ['idcontract' => $contract, 'id' => $id, 'objeto' => $objeto]);
    }

    public function store($idcontract, $idantigo, Request $request) {
        $post = request()->all();
        $objeto = new Brindes();
        if ($idantigo) {
            $objeto = $objeto->find($idantigo);
        }
        if ($request->hasFile("foto")) {
            $md5 = md5(uniqid(rand(), true));
            $file = $request->file('foto');
            $nomePastaDestino = Storage::disk('public')->path('uploads/brindes');
            File::isDirectory($nomePastaDestino) or File::makeDirectory($nomePastaDestino, 0777, true, true);
            $novoNome = $md5 . '.' . $file->getClientOriginalExtension();
            $file->move(Storage::disk('public')->path('uploads/brindes'), $novoNome);
            $objeto->pathfile = $novoNome;
        }
        $objeto->nome = $post['nome'];
        $objeto->descricao = $post['descricao'];
        $objeto->contract_id = $idcontract;
        $objeto->save();
        session()->flash('sucesso', true);
        return redirect(url("/gerencial/brindes/" . $idcontract . "/index"));
    }

}
