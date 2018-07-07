<?php

include __DIR__.'/vendor/autoload.php';

use GQuemener\Github\EventsApi;
use GQuemener\Prooph\GithubEventStore;
use Prooph\EventStore\StreamName;

$eventsApi = new EventsApi(__DIR__.'/cache');
$eventStore = new GithubEventStore($eventsApi);
$events = $eventStore->load(new StreamName('gquemener'), 7927696431);

die(var_dump(\iterator_to_array($events)[1]));
