<?php

namespace App\Infrastructure;

/**
 * @template T
 */
class Set
{
    /**
     * @var array<T, true>
     */
    protected array $map = [];

    /**
     * @param  array<T>|array<mixed, T>  $items
     */
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param  T  $value
     * @return void
     */
    public function add(mixed $value): void
    {
        $this->map[$value] = true;
    }

    /**
     * @param  T  $value
     * @return bool
     */
    public function contains(mixed $value): bool
    {
        return $this->map[$value] ?? false;
    }
}
