<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PollController extends Controller
{
    public function index(){
        return view('portal.polls.index');
    }

    public function show($poll){
        return view('portal.polls.show');
    }
}
