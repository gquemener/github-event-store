<?php

namespace spec\GQuemener\Prooph;

use GQuemener\Prooph\GithubEventMessageFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prooph\Common\Messaging\MessageFactory;

class GithubEventMessageFactorySpec extends ObjectBehavior
{
    function it_is_a_prooph_message_factory()
    {
        $this->shouldBeAnInstanceOf(MessageFactory::class);
    }
}
