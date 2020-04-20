<?php

namespace Implementation\Services;

interface OutputInterface
{
    /**
     * @param string $message
     * @param string|null $key
     * @return $this
     */
    public function error(string $message, string $key = null): self;

    /**
     * @param $data
     * @param string|null $key
     * @return $this
     */
    public function put($data, string $key = null): self;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return array
     */
    public function getErrors(): array;
}