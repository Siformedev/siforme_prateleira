<?php

namespace App\Http\Controllers;


use App\Course;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index(){
        $cursos = Course::all();
        return view('gerencial.cursos.index', compact('cursos'));
    }

    public function store(Request $request) 
    {
        $curso = Course::create([
            'name'=>$request->nome,
            'status'=>1
        ]);

        return redirect()->back(); 
    }

    public function delete($id){
        
        
        try {
            Course::destroy($id);
            return redirect()->back(); 
        } catch (\Throwable $th) {
            return redirect()->back(); 
        }
       
        
    }
}
