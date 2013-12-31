<?php

namespace App\DTO;

abstract class AbstractTransfer
{
    /**
     * @param array<mixed> $data
     * @return $this
     */
    abstract public function fromArray(array $data): self;
}
