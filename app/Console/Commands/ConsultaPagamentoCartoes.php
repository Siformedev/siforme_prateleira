<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\IuguController;
use App\Http\Controllers\WebhookController;
use App\PagamentosCartao;
use App\Services\IuguService;
use Illuminate\Console\Command;

class ConsultaPagamentoCartoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhook:consultapgscartoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consuta e atualiza pagamentos cartões iugu';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(IuguController $iuguController, IuguService $iuguService)
    {
        $retorno = '';
        $pg = PagamentosCartao::where('status', '')->first();
        if($pg){
            $retorno = $iuguService->consultarInvoice($pg->invoice_id);
            $iuguController->baixaCartao($retorno);
        }
        return $retorno;


    }
}
