<?php

namespace Implementation\Services;

interface OutputInterface
{
    /**
     * @param $data
     * @param string|null $key
     * @return $this
     */
    public function put($data, string $key = null): self;
}