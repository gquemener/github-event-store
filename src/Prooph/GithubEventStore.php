<?php

namespace GQuemener\Prooph;

use Iterator;
use Prooph\EventStore\ReadOnlyEventStore;
use Prooph\EventStore\StreamName;
use Prooph\EventStore\Metadata\MetadataMatcher;
use GQuemener\Github\EventsApi;
use Prooph\Common\Messaging\FQCNMessageFactory;

final class GithubEventStore implements ReadOnlyEventStore
{
    private $events;
    private $messageFactory;

    public function __construct(EventsApi $events)
    {
        $this->events = $events;
        $this->messageFactory = new FQCNMessageFactory();
    }

    public function fetchStreamMetadata(StreamName $streamName): array
    {
    }

    public function hasStream(StreamName $streamName): bool
    {
    }

    public function load(
        StreamName $streamName,
        int $fromNumber = 1,
        int $count = null,
        MetadataMatcher $metadataMatcher = null
    ): Iterator
    {
        $events = [];
        foreach ($this->events->all($streamName->toString()) as $event) {
            if ($event['id'] === (string) $fromNumber) {
                return new GithubEventsIterator($events, $this->messageFactory);
            }

            array_unshift($events, $event);
        }

        return new GithubEventsIterator($events, $this->messageFactory);
    }

    public function loadReverse(
        StreamName $streamName,
        int $fromNumber = null,
        int $count = null,
        MetadataMatcher $metadataMatcher = null
    ): Iterator
    {
    }

    public function fetchStreamNames(
        ?string $filter,
        ?MetadataMatcher $metadataMatcher,
        int $limit = 20,
        int $offset = 0
    ): array
    {
    }

    public function fetchStreamNamesRegex(
        string $filter,
        ?MetadataMatcher $metadataMatcher,
        int $limit = 20,
        int $offset = 0
    ): array
    {
    }

    public function fetchCategoryNames(?string $filter, int $limit = 20, int $offset = 0): array
    {
    }

    public function fetchCategoryNamesRegex(string $filter, int $limit = 20, int $offset = 0): array
    {
    }
}
