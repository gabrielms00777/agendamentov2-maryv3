<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Teste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $whatsapp = new WhatsAppService(); // Usa o provider padrão
        $response = $whatsapp->sendText(
            '5516981294778',
            'Mensagem de teste'
        );

        // $response = Http::withHeaders([
        //     'apikey' => env('WHATSAPP_EVOLUTION_API_KEY'),
        // ])->post("http://evo-swck88o4c8gs4s48g40cos0k.173.249.28.155.sslip.io/message/sendText/Teste", [
        //     'number' => '5516981294778',
        //     'text' => 'Testeeee'
        // ]);

        dd($response);
    }
}
