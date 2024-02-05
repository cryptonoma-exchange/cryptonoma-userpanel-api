<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as Reactor;

use App\Http\Controllers\WebSocketChatController;

class WebSocketChatServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocketchat:init';

    /**
     * The console command description.
     *
     * @var string
     */
      protected $description = 'Initializing Websocket server to receive and manage connections';

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
     * 
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $host = env('RATCHET_HOST') ? env('RATCHET_HOST') : 'ws://demozab.com';
        $port = env('RATCHET_PORT') ? env('RATCHET_PORT') : 9091;
        echo "Ratchet server started on $host:$port \n";
        $loop = \React\EventLoop\Factory::create();
        $socket = new Reactor('0.0.0.0:' . $port, $loop);
        $wsServer = new WsServer(new WebSocketChatController($loop));
        $server = new IoServer(new HttpServer($wsServer), $socket, $loop);
        $wsServer->enableKeepAlive($server->loop, 10);
        $server->run();
    }
}
