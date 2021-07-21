<?php

namespace App\Console\Commands;

use App\Http\Controllers\WebhookController;
use App\Services\IuguService;
use Illuminate\Console\Command;

class GeraTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhook:geratickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera tickets';

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
    public function handle(WebhookController $webhookController)
    {
        $webhookController->geraTickets();
        $webhookController->geraTicketsNull();
    }
}
