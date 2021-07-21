<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;


class Brindesretirados extends Eloquent
{
    protected $table = 'brindes_retirados';
    protected $fillable = [
        'id',
        'contract_id',
        'linkpdf',
        'pathfile'
    ];
    
    
    function procuraBrindeRetiado($idbrinde,$idformando){
        
        
        return $this->from('brindes_retirados')->where('brinde_id',$idbrinde)->where('forming_id',$idformando)->first();
        
        
        
    }

}
