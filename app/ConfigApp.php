<?php

namespace App;

class ConfigApp
{

    public static function Periodos()
    {
        return [
            '1' => 'Matutino',
            '2' => 'Diurno',
            '3' => 'Noturno',
            '4' => 'Integral',
            '5' => 'Vespertino',
        ];
    }

    public static function Calcados()
    {
        return [
            '33/34' => '33/34',
            '35/36' => '35/36',
            '37/38' => '37/38',
            '39/40' => '39/40',
            '41/42' => '41/42',
            '43/44' => '43/44',
            '45/46' => '45/46',
            '47/48' => '47/48',
        ];
    }

    public static function SetoresChamados()
    {
        return [
            '1' => 'Formando',
            '2' => 'Comissão'
        ];
    }

    public static function AssuntosChamados()
    {
        return [
            '1' => 'Pagamento',
            '2' => 'Brindes',
            '3' => 'Plantões',
            '5' => 'Cadastro / Dados',
            '4' => 'Cancelamento',
            '6' => 'Outros',
        ];
    }

    public static function ChamadosStatus()
    {
        return [
            '1' => 'Aberto',
            '2' => 'Finalizado',
            '6' => 'Respondido'
        ];
    }

    public static function AnosConclusao()
    {
        $ano = date('Y');
        $incrementar = 7;
        for($i = $ano; $i <= ($ano+$incrementar); $i++){
            $r[$i] = (int)$i;
        }
        return $r;
    }

    public static function MesConclusao()
    {
        return [
            '7' => 'JULHO',
            '6' => 'JUNHO',
            '12' => 'DEZEMBRO',
            '1' => 'JANEIRO'
        ];
    }

    public static function FormingStatus()
    {
        return [
            '1' => 'Aderido',
            '6' => 'Solicitado Cancelamento',
            '7' => 'Cancelado'
        ];
    }

    public static function StatusProductsAndServices()
    {
        return [
            1 => 'Ativo',
            6 => 'Cancelado',
            7 => 'Desativado'
        ];
    }

    public static function CollaboratorNivel()
    {
        return [
            1 => 'Nível 1',
            9 => 'Nível 9'
        ];
    }

    public static function CollaboratorDepartment()
    {
        return [
            1 => 'Tecnologia',
            2 => 'Financeiro',
            3 => 'Atendimento',
            4 => 'Pós Contrato',
            5 => 'Comercial',
            6 => 'Fotográfia'
        ];
    }

    public static function GiftRequetsStatus()
    {
        return [
            1 => 'Pedido Realizado',
            2 => 'Aprovado',
            3 => 'Produção',
            4 => 'Aguardando Retirada',
            5 => 'Entregue'
        ];
    }
}
