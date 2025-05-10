<?php

namespace App\Infrastructure\Storage;

use App\Domain\Storage\MetricsStorageInterface;
use Domnikl\Statsd\Client;
use Domnikl\Statsd\Connection\UdpSocket;

class MetricsStorage implements MetricsStorageInterface
{
    public const TASK_CREATED = 'task_created';
    public const TASK_DELETED = 'task_deleted';

    private const MARK_CREATED = 'mark_created';

    private const DEFAULT_SAMPLE_RATE = 1.0;

    private Client $client;

    public function __construct(string $host, int $port, string $namespace)
    {
        $connection = new UdpSocket($host, $port);
        $this->client = new Client($connection, $namespace);
    }

    public function increment(string $key, ?float $sampleRate = null, ?array $tags = null): void
    {
        $this->client->increment($key, $sampleRate ?? self::DEFAULT_SAMPLE_RATE, $tags ?? []);
    }

    public function getCode(string $code): string|null
    {
        /*
         * Это хорошее решение?
         */
        $code = strtoupper($code);
        return (defined("self::$code")) ? constant("self::$code") : null;
    }
}