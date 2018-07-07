<?php

declare(strict_types=1);

namespace GQuemener\Prooph;

use Iterator;
use Prooph\Common\Messaging\MessageFactory;
use Prooph\Common\Messaging\Message;

final class GithubEventsIterator implements Iterator
{
    public function __construct(array $events, MessageFactory $messageFactory)
    {
        $this->events = new \ArrayIterator($events);
        $this->messageFactory = $messageFactory;
    }

    public function current(): ?Message
    {
        if (false === $currentItem = $this->events->current()) {
            return null;
        }

        $messageData = [
            'created_at' => new \DateTimeImmutable($currentItem['created_at']),
            'payload' => $currentItem['payload'],
        ];

        return $this->messageFactory->createMessageFromArray(
            'GQuemener\\Prooph\\Event\\' . $currentItem['type'],
            $messageData
        );
    }

    public function key()
    {
        return $this->events->key();
    }

    public function next()
    {
        $this->events->next();
    }

    public function rewind()
    {
        $this->events->rewind();
    }

    public function valid(): bool
    {
        return $this->events->valid();
    }
}
