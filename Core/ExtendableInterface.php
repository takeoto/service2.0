<?php

namespace Core;

interface ExtendableInterface
{
    public function extend(ExtendableInterface $extendable);
    public function getOptions(): array;
}