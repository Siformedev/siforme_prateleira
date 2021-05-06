<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/03/17
 * Time: 13:18
 */

namespace App\Helpers;


class DateHelper
{

    public static function ConvertMonth($monthNum)
    {
        if(is_int($monthNum)){
            switch ($monthNum){
                case 1:
                    return 'JAN';
                    break;

                case 2:
                    return 'FEV';
                    break;

                case 3:
                    return 'MAR';
                    break;

                case 4:
                    return 'ABR';
                    break;

                case 5:
                    return 'MAI';
                    break;

                case 6:
                    return 'JUN';
                    break;

                case 7:
                    return 'JUL';
                    break;

                case 8:
                    return 'AGO';
                    break;

                case 9:
                    return 'SET';
                    break;

                case 10:
                    return 'OUT';
                    break;

                case 11:
                    return 'NOV';
                    break;

                case 12:
                    return 'DEZ';
                    break;

                default:
                    return false;
                    break;
            }
        }
    }

}