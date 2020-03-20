<?php

namespace App\Service\RabbitMQ;

use App\Entity\Collections;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CollectionHandler implements MessageHandlerInterface
{
    public function __invoke(Collections $addCollection)
    {
        //dump($addCollection);
        return $addCollection;
    }
}