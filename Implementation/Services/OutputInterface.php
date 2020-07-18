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
    public function get(?string $key = null, $default = null);
}