<?php

class ServiceOutput
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $errors;

    /**
     * @param string $message
     * @param string|null $key
     * @return self
     */
    public function error(string $message, string $key = null): self
    {
        $key === null
            ? $this->errors[] = $message
            : $this->errors[$key] = $message;

        return $this;
    }

    /**
     * @param $data
     * @param string $key
     * @return $this
     */
    public function put($data, string $key = null): self
    {
        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        } else {
            $key === null
                ? $this->data[] = $data
                : $this->data[$key] = $data;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        if (empty($this->data)) {
            return null;
        }

        return count($this->data) === 1 && key($this->data) === 0 ? reset($this->data) : $this->data;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
