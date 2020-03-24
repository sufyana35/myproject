<?php

namespace App\Service\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class receive
{

    public function receive()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'root', 'r00t');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}