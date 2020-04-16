<?php


interface ResultInterface extends ServiceResultInterface
{
    public function getData(): StrictValue;
}