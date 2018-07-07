<?php

namespace GQuemener\Prooph;

use Prooph\Common\Messaging\MessageFactory;
use Prooph\Common\Messaging\Message;
use Ramsey\Uuid\Uuid;
use GQuemener\Prooph\Event\GithubEvent;

class GithubEventMessageFactory implements MessageFactory
{
    public function createMessageFromArray(string $messageName, array $messageData): Message
    {
        die(var_dump($arguments));
        return GithubEvent::fromArray([
            'uuid' => Uuid::uuid4()->toString(),
            'message_name' => $messageName,
            'metadata' => [],
            'created_at' => new \DateTimeImmutable($messageData['pull_request']['updated_at']),
            'payload' => $messageData['pull_request'],
        ]);
    }
}
