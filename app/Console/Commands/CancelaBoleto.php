<?php

namespace App\Console\Commands;

use App\Http\Controllers\WebhookController;
use App\Services\IuguService;
use Illuminate\Console\Command;

class CancelaBoleto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhook:cancelaboleto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancela boletos';

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
    public function handle(WebhookController $webhookController, IuguService $iuguService)
    {
        $webhookController->cancelaBoletos($iuguService);
    }
}
