<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 14:28
 */

namespace App\Services;

use App\Forming;
use App\Ticket;
use Illuminate\Support\Facades\Hash;

class TicketServices
{

    public function geraTicket($event_id, $forming_id, $fps_id)
    {

        $exists = true;
        while($exists == true){
            $code = substr(uniqid(rand(), true), 0, 20).substr(uniqid(rand(), true), 0, 20);
            $verif = Ticket::where('code', $code)->get();
            if($verif->count() <= 0){
                $tickets = Ticket::create([
                    'event_id' => $event_id,
                    'forming_id' => $forming_id,
                    'code' => $code,
                    'fps_id' => $fps_id,
                    'status' => 1
                ]);
                $exists = false;
            }
        }

        if(isset($tickets)){
            return $tickets;
        }else{
            return false;
        }

    }

}