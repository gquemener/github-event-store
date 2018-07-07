<?php

declare(strict_types=1);

namespace GQuemener\Prooph\Event;

use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class DeleteEvent extends DomainEvent implements PayloadConstructable
{
    use PayloadTrait;
}