<?php

namespace App\Http\Controllers\Gerencial;

use App\Collaborator;
use App\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CollaboratorController extends Controller
{

    private $collaborators;

    public function __construct(Collaborator $collaborators)
    {
        $this->collaborators = $collaborators;
    }

    public function create()
    {
        return view('gerencial.collaborator.create');
    }

    public function index()
    {
        return view('gerencial.collaborator.index', ['collaborators' => $this->collaborators->get()]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email",
            "cpf" => "required",
            "department" => "required",
            "password" => "required"
        ]);
        $data = $request->all();

        $user['name'] = $data['name'];
        $user['email'] = $data['email'];
        unset($data['email']);
        $user['password'] = bcrypt($data['password']);
        unset($data['password']);
        $data['status'] = 1;
        $collaborator = $this->collaborators->create($data);
        $user = \App\User::create($user);
        $user->userable()->associate($collaborator);
        $user->save();

        return redirect()->route('gerencial.collaborator.index');
    }

    public function edit(Collaborator $collaborator)
    {
        return view('gerencial.collaborator.edit', ['collaborator' =>$collaborator]);
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email",
            "cpf" => "required",
            "department" => "required"
        ]);
        $data = $request->all();
        unset($data['_token']);
        $user['name'] = $data['name'];
        $user['email'] = $data['email'];
        unset($data['email']);
        if(!empty($data['password'])){
            $user['password'] = bcrypt($data['password']);
        }
        unset($data['password']);

        $collaborator->update($data);
        $collaborator->user()->update($user);
        $request->session()->flash('message', 'O colaborador '.$data['name'].' foi atualizado com sucesso!');
        return redirect()->route('gerencial.collaborator.index');
    }


}
