<?php

namespace App\Console\Commands;

use App\AuditAndLog;
use App\Chamado;
use App\ConfigApp;
use App\Contract;
use App\Course;
use App\Event;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosEServicosCateriasTipos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\Gift;
use App\GiftRequests;
use App\GiftRequestsGifts;
use App\Helpers\ConvertData;
use App\Helpers\DateHelper;
use App\Informativo;
use App\Mail\RaffleMail;
use App\PagamentosBoleto;
use App\PagamentosCartao;
use App\ParcelasPagamentos;
use App\ProductAndService;
use App\ProductAndServiceDiscounts;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use App\Raffle;
use App\RaffleNumbers;
use App\Services\IuguService;
use App\Services\PagSeguroService;
use App\Services\ProdutosService;
use App\Services\RaffleServices;
use App\Services\TicketServices;
use App\Survey;
use App\SurveyAnswer;
use App\Ticket;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Console\Command;

class CheckPaiment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(PagSeguroService $pseg)
    {
        $boletos_pendentes = PagamentosBoleto::where('status','Pendente')->get();
        $contrato_id = 3; 
        $result=[];
 
        foreach ($boletos_pendentes as $key => $value) {
            $transaction = $pseg->consultarTransacao($value->invoice_id,$contrato_id);
            $status_trn = $pseg->cod_status($transaction->status);
            $date = new DateTime($transaction->date);
            $paid_at = new DateTime($transaction->lastEventDate);
            
            if ($transaction->status == 1) {
                
                //formandos produto parcelas
                $parcela = FormandoProdutosParcelas::find($transaction->reference);
                $parcela->update(['status' => 1]);

                //parcelas pagamentos (se não houver, cria)
                $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();
                if (!$pagamento) {
                    $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => $transaction->grossAmount]);
                } else {
                    $pagamento->update(['valor_pago' => ($transaction->grossAmount), 'deleted' => 0]);
                }

                //pagamentos boleto
                $dataInsert = [
                    'valor_pago' => $transaction->grossAmount,
                    'payable_with' => null,
                    'due_date' => $date,
                    'total_cents' => 0,
                    'paid_cents' => 0,
                    'status' => 'paid',
                    'paid_at' => $paid_at,
                    'secure_url' => $transaction->paymentLink,
                    'taxes_paid_cents' => 0,
                    'deleted' => 0,
                ];
                $pgBoleto = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id);
                $pgBoleto->update($dataInsert);

                $pgBoletoGet = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id)->get()->first();

                $parcelaPagamento = ParcelasPagamentos::find($pgBoletoGet->parcela_pagamento_id);
                $parcelaPagamento->update(['valor_pago' => $transaction->grossAmount, 'deleted' => 0]);

                // fim das atualizações das tabelas
        
                $result[$value->invoice_id]['parcela'] = $transaction->reference;  
                $result[$value->invoice_id]['status'] = $transaction->status;  
            }
           
        }

    }
}
