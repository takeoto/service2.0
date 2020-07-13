<?php
namespace Implementation\Services;

class ServiceOutput implements OutputInterface
{
    /**
     * @var mixed
     */
    private $data = null;

    /**
     * @param $data
     * @param string $key
     * @return $this
     */
    public function put($data, string $key = null): self
    {
        switch (true) {
            case is_null($this->data):
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
