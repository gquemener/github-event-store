<?php

declare(strict_types=1);

namespace GQuemener\Github;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Strategy\PublicCacheStrategy;
use Kevinrob\GuzzleCache\Storage\Psr16CacheStorage;
use Symfony\Component\Cache\Simple\FilesystemCache;

class EventsApi
{
    private $httpClient;

    public function __construct(string $cacheDir = null)
    {
        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(
            new PublicCacheStrategy(
                new Psr16CacheStorage(
                    new FilesystemCache('github-event-store', 0, $cacheDir)
                )
            )
        ), 'cache');
        $this->httpClient = new HttpClient(['handler' => $stack]);
    }

    public function all(string $username): \Iterator
    {
        foreach (range(1, 10) as $page) {
            $response = $this->httpClient->get(sprintf('https://api.github.com/users/%s/events', $username), [
                'query' => [
                    'page' => $page,
                ]
            ]);

            yield from json_decode((string) $response->getBody(), true);
        }
    }
}
