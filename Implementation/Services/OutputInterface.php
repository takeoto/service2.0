<?php

namespace Implementation\Services;

interface OutputInterface
{
    /**
     * @param $data
     * @param string|null $key
     * @return self
     */
    public function put($data, ?string $key = null): self;

    /**
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function get($default = null, ?string $key = null);

    /**
     * @param string|null $key
     * @return bool
     */
    public function has(string $key = null): bool;
}