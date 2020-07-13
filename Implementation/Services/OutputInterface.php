<?php

namespace Implementation\Services;

interface OutputInterface
{
    /**
     * @param $data
     * @param string|null $key
     * @return self
     */
    public function put($data, string $key = null): self;
    
    /**
     * @return mixed
     */
    public function getData();
}