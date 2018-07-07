<?php

namespace spec\GQuemener\Prooph;

use GQuemener\Prooph\GithubEventStore;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prooph\EventStore\ReadOnlyEventStore;
use GQuemener\Github\EventsApi;
use Prooph\EventStore\StreamName;

class GithubEventStoreSpec extends ObjectBehavior
{
    function let(EventsApi $events)
    {
        $this->beConstructedWith($events);
    }

    function it_is_a_prooph_read_only_event_store()
    {
        $this->shouldBeAnInstanceOf(ReadOnlyEventStore::class);
    }

    function it_loads_a_stream_of_github_user_events(
        StreamName $name,
        $events
    ) {
        $name->toString()->willReturn('github_user');
        $events->all('github_user')->willReturn(new \ArrayIterator([
            ['id' => '14'],
            ['id' => '13'],
            ['id' => '12'],
            ['id' => '11'],
            ['id' => '10'],
        ]));

        $iterator = $this->load($name);
        $iterator->rewind();
        $iterator->current()->shouldBe(['id' => '10']);
        $iterator->next();
        $iterator->current()->shouldBe(['id' => '11']);
        $iterator->next();
        $iterator->current()->shouldBe(['id' => '12']);
        $iterator->next();
        $iterator->current()->shouldBe(['id' => '13']);
        $iterator->next();
        $iterator->current()->shouldBe(['id' => '14']);
        $iterator->next();
        $iterator->valid()->shouldBe(false);
    }

    function it_loads_a_stream_of_github_user_events_from_a_specific_event_id(
        StreamName $name,
        $events
    ) {
        $name->toString()->willReturn('github_user');
        $events->all('github_user')->willReturn(new \ArrayIterator([
            ['id' => '14'],
            ['id' => '13'],
            ['id' => '12'],
            ['id' => '11'],
            ['id' => '10'],
        ]));

        $iterator = $this->load($name, '12');
        $iterator->rewind();
        $iterator->current()->shouldBe(['id' => '13']);
        $iterator->next();
        $iterator->current()->shouldBe(['id' => '14']);
        $iterator->next();
        $iterator->valid()->shouldBe(false);
    }
}
