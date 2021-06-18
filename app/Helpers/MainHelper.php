<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

/**
 * 
 * Essa classe foi desenvolvida com o intuito de estar disponibilizando funcionalidades disponíveis no sistema em um 
 * escopo global em se tratando do sistema.
 * @author Rafael Dantas Fortes
 * @since 04/05/2021
 * 
 */
class MainHelper {

    function __construct() {
        
    }

    function debugquery($query, $die = true) {
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        dump($sql);
        dump($bindings);
        if ($die)
            return exit;
    }

    function log($formingId, $action) {
        $model = new \App\Logs();
        $model->action = $action;
        $model->forming_id = $formingId;
        $model->save();
    }

    function toMysqlDate($data, $paraobanco = true) {
        if ($paraobanco) {
            if (strlen($data) == 10) {
                return implode("-", array_reverse(explode("/", $data)));
            } else if (strlen($data) == 16) {
                $expld = explode(" ", $data);
                $comecodata = implode("-", array_reverse(explode("/", $expld[0])));
                $fimdata = $expld[1] . ":00";
                return $comecodata . " " . $fimdata;
            }
        } else {
            if (strlen($data) == 10) {
                return implode("/", array_reverse(explode("-", $data)));
            } else if (strlen($data) == 16 or strlen($data) == 19) {
                $expld = explode(" ", $data);
                $comecodata = implode("/", array_reverse(explode("-", $expld[0])));
                $fimdata = substr($expld[1], 0, 5);
                return $comecodata . " " . $fimdata;
            }
        }
    }

}
