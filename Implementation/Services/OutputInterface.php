<?php

namespace Implementation\Services;

interface OutputInterface
{
    /**
     * @param mixed $data
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

    /**
     * @param string|null $key
     * @return bool
     */
    public function has(?string $key = null): bool;

    /**
     * @param string|null $key
     * @return self
     */
    public function unset(?string $key = null): self;
}