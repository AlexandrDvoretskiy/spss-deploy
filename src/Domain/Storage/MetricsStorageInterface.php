<?php

namespace App\Domain\Storage;

interface MetricsStorageInterface
{
    public function increment(string $key, ?float $sampleRate = null, ?array $tags = null): void;
}