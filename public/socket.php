<?php
/**
 * php -q socket.php
 * seklinde websocket sunucu aktif edilebiliyor
 */
include 'connect.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('localhost', 8080);
$app->route('/chat', new MyChat, array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
$app->run();

$api->miniTicker( function ( $api, $ticker ) use ( &$count ) {

    $count++;
    print $count . "\n";
    if($count > 2) {
        $endpoint = '@miniticker';
        $api->terminate( $endpoint );
    }
} );