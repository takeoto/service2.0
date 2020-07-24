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
            return $this->data ?? $default;
        }
        
        return is_array($this->data) ? $this->data[$key] ?? $default : $default; 
    }

    /**
     * @inheritDoc
     */
    public function has(?string $key = null): bool
    {
        if ($key === null) {
            return $this->data !== null; 
        }
        
        return is_array($this->data) ? isset($this->data[$key]) : false; 
    }

    /**
     * @inheritDoc
     */
    public function unset(?string $key = null): void
    {
        if ($key === null) {
            $this->data = null;
        } elseif (is_array($this->data)) {
            unset($this->data[$key]);
        }
    }
}
