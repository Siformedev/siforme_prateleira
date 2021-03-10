<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AuditAndLog extends Model
{
    protected $table = 'audits_and_logs';

    protected $fillable = [
        'user_id',
        'action',
        'type_values',
        'contract_id',
        'old_values',
        'new_values'
    ];

    public static function createLog($user, $action, $type, $contract, $old_values = '', $new_values = '')
    {
        $data = [
            'user_id' => $user,
            'action' => $action,
            'type_values' => $type,
            'contract_id' => $contract,
            'old_values' => $old_values,
            'new_values' => $new_values
        ];

        return self::create($data);
    }
}
