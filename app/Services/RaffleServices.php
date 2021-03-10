<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 14:28
 */

namespace App\Services;

use App\Forming;
use App\Raffle;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Void_;

class RaffleServices
{
    static $newNumber;

    /**
     * @param Integer $numberOfNumbers
     * @param $dadosContrato
     */
    public function generateNumbers(int $numberOfNumbers, Forming $forming, Raffle $raffle)
    {
        for ($i=1; $i<=$numberOfNumbers; $i++){

            $validNumber = false;

            while ($validNumber == false){
                $this->registryValueRandom($raffle->raffle_numbers_start, $raffle->raffle_numbers_end);
                $result = $raffle->numbers->where('number', self::$newNumber)->where('raffle_id', $raffle->id);
                if($result->count() > 0){
                    $this->registryValueRandom($raffle->raffle_numbers_start, $raffle->raffle_numbers_end);
                    continue;
                }else{
                    try{

                        $register = $raffle->numbers()->create([
                            'raffle_id' => $raffle->id,
                            'number' => self::$newNumber,
                            'forming_id' => $forming->id,
                            'hash' =>  md5(self::$newNumber.$raffle->id.$forming->id),
                        ]);

                    }catch (\ErrorException $exception){
                        dd($exception);
                    }
                    $validNumber = true;
                }
            }
        }

    }

    private function registryValueRandom($initialNumber, $finalNumber)
    {
        self::$newNumber = 0;
        self::$newNumber = rand($initialNumber, $finalNumber);
    }


}