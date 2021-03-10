<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 14:28
 */

namespace App\Services;

use App\Forming;
use App\GiftRequests;
use App\Raffle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Void_;

class GiftRequestServices
{
    static $newNumber;

    /**
     * @param Integer $numberOfNumbers
     * @param $dadosContrato
     */
    public static function calculateInfos(GiftRequests $giftRequests)
    {
        $vendaTemp = $giftRequests->toArray();

        $vendaTemp['quants'] = $giftRequests->gifts()->count();

        $vendaTemp['forming_name'] = str_limit($giftRequests->forming->nome." ".$giftRequests->forming->sobrenome, 25, '');
        $vendaTemp['forming_id'] = $giftRequests->forming->id;

        //Taxa
        $taxa = $vendaTemp['total'] * (2.51 / 100);
        $vendaTemp['rate'] = number_format($taxa, 2);

        //Data recebimento
        $created_at = $giftRequests->created_at;
        $date = Carbon::parse($created_at);
        $date2 = Carbon::now();
        $date->addDays(31);

        $vendaTemp['receiving'] = false;
        $vendaTemp['receiving_date'] = $date->format('Y-m-d H:i:s');

        $diff = $date->diffInDays($date2, false);
        if($diff >= 0){
            $vendaTemp['receiving'] = true;
        }

        return $vendaTemp;
    }


}