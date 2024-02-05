<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\WebSocketController;

use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as Reactor;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:init';

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

        $host = env('RATCHET_HOST') ? env('RATCHET_HOST') : 'ws://localhost';
        $port = env('RATCHET_PORT') ? env('RATCHET_PORT') : 9090;
        echo "Ratchet server started on $host:$port \n";
        $loop = \React\EventLoop\Factory::create();
        $socket = new Reactor('0.0.0.0:' . $port, $loop);
        $wsServer = new WsServer(new WebSocketController($loop));
        $server = new IoServer(new HttpServer($wsServer), $socket, $loop);
        $wsServer->enableKeepAlive($server->loop, 10);
        $server->run();

           /*  $server = \Ratchet\Server\IoServer::factory(
            new \Ratchet\Http\HttpServer(
            new \Ratchet\WebSocket\WsServer(
            new \App\Http\Controllers\WebSocketController()
            )
            ),
            9090
            );
            $server->run();*/
    }
}
