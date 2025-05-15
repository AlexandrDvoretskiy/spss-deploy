<?php

namespace App\Application\Symfony;

use App\Domain\Storage\MetricsStorageInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Cache\ResettableInterface;
use Symfony\Contracts\Cache\CacheInterface;

class AdapterCountingDecorator implements AdapterInterface, CacheInterface, LoggerAwareInterface, ResettableInterface
{

    public function __construct(
        private readonly AdapterInterface $adapter,
        private readonly MetricsStorageInterface $metricsStorage
    ) {
        $this->adapter->setCallbackWrapper(null);
    }

    public function getItem(mixed $key): CacheItem
    {
        $result = $this->adapter->getItem($key);
        $this->incCounter($result);

        return $result;
    }

    public function getItems(array $keys = []): iterable
    {
        $result = $this->adapter->getItems($keys);
        foreach ($result as $item) {
            $this->incCounter($item);
        }

        return $result;
    }

    public function clear(string $prefix = ''): bool
    {
        return $this->adapter->clear($prefix);
    }

    public function get(string $key, callable $callback, ?float $beta = null, ?array &$metadata = null): mixed
    {
        return $this->adapter->get($key, $callback, $beta, $metadata);
    }

    public function delete(string $key): bool
    {
        return $this->adapter->delete($key);
    }

    public function hasItem(string $key): bool
    {
        return $this->adapter->hasItem($key);
    }

    public function deleteItem(string $key): bool
    {
        return $this->adapter->deleteItem($key);
    }

    public function deleteItems(array $keys): bool
    {
        return $this->adapter->deleteItems($keys);
    }

    public function save(CacheItemInterface $item): bool
    {
        return $this->adapter->save($item);
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        return $this->adapter->saveDeferred($item);
    }

    public function commit(): bool
    {
        return $this->adapter->commit();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->adapter->setLogger($logger);
    }

    public function reset(): void
    {
        $this->adapter->reset();
    }

    private function incCounter(CacheItemInterface $cacheItem): void
    {
        if ($cacheItem->isHit()) {
            if ($code = $this->metricsStorage->getCode("CACHE_HIT_PREFIX")) {
                $this->metricsStorage->increment($code . $cacheItem->getKey());
            }
        } else {
            if ($code = $this->metricsStorage->getCode("CACHE_MISS_PREFIX")) {
                $this->metricsStorage->increment($code . $cacheItem->getKey());
            }
        }
    }
}