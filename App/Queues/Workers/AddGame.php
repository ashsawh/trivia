<?php
namespace Acme\AmqpWrapper;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once '../../../vendor/autoload.php';

class GamesModify
{
    protected $corrId;
    protected $response;

    public function execute($query, $queue)
    {
        $queryData = json_encode($query);
        $this->createConn($queryData, $queue);
    }

    protected function createConn($queryData, $queue)
    {
        $connection = new AMQPConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare(
            $queue,    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            false,              #passive - can use this to check whether an exchange exists without modifying the server state
            true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
            false,              #exclusive - used by only one connection and the queue will be deleted when that connection closes
            false               #auto delete - queue is deleted when last consumer unsubscribes
        );

        $msg = new AMQPMessage(
            $queryData,
            array('delivery_mode' => 2) # make message persistent, so it is not lost if server crashes or quits
        );

        $channel->basic_publish(
            $msg,               #message
            '',                 #exchange
            $queue     #routing key (queue)
        );

        $channel->close();
        $connection->close();
    }
}

$a = (new GamesModify())->execute(array(
    "invoke" => "store",
    "params" => array(
        'gameId' => 7
    ),
    "payload" => array(
        "state" => true,
        "score" => 5,
        "user_id" => 1
    )), 'storeGame'
);
