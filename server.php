<!---
░██╗░░░░░░░██╗███████╗██████╗░░██████╗░█████╗░░█████╗░██╗░░██╗███████╗████████╗
░██║░░██╗░░██║██╔════╝██╔══██╗██╔════╝██╔══██╗██╔══██╗██║░██╔╝██╔════╝╚══██╔══╝
░╚██╗████╗██╔╝█████╗░░██████╦╝╚█████╗░██║░░██║██║░░╚═╝█████═╝░█████╗░░░░░██║░░░
░░████╔═████║░██╔══╝░░██╔══██╗░╚═══██╗██║░░██║██║░░██╗██╔═██╗░██╔══╝░░░░░██║░░░
░░╚██╔╝░╚██╔╝░███████╗██████╦╝██████╔╝╚█████╔╝╚█████╔╝██║░╚██╗███████╗░░░██║░░░
░░░╚═╝░░░╚═╝░░╚══════╝╚═════╝░╚═════╝░░╚════╝░░╚════╝░╚═╝░░╚═╝╚══════╝░░░╚═╝░░░__websocket_david_fonse_davidcreat_eas1
𝙐𝙎𝘼𝙉𝘿𝙊:
- 𝘾𝙊𝙈𝙋𝙊𝙎𝙀𝙍
- 𝙍𝘼𝙏𝘾𝙃𝙀𝙏
-->
<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'vendor/autoload.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nueva conexión! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Conexión {$conn->resourceId} se ha desconectado\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ocurrió un error: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = \Ratchet\Server\IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();
