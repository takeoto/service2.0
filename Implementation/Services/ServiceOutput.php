<?php
namespace Implementation\Services;

class ServiceOutput implements OutputInterface
{
    /**
     * @var mixed
     */
    private $data = null;

    /**
     * @inheritDoc
     */
    public function put($data, string $key = null): self
    {
        switch (true) {
            case $this->data === null:
                $this->data = $key === null ? $data : [$key => $data];
                break;
            case is_array($this->data):
                $key === null ? $this->data[] = $data : $this->data[$key] = $data;
                break;
            default:
                $this->data = $key === null ? [$this->data, $data] : [$this->data, $key => $data];
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }
        
        return  is_array($this->data) ? $this->data[$key] ?? $default : $default; 
    }
}
