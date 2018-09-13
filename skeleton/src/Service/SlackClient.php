<?php

namespace App\Service;

use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
use App\Helper\LoggerTrait;

class SlackClient
{
    private $slack;

    use LoggerTrait;

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }



    public function sendMessage(string $from, string $message)
    {
        $this->logInfo('Beaming a message to Slack!', ['message' => $message]);

        $message = $this->slack->createMessage()
                               ->from($from)
                               ->withIcon(':ghost:')
                               ->setText($message);

        ;
        $this->slack->sendMessage($message);
    }
}
