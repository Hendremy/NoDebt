<?php

namespace NoDebt;

class Bill
{
    private $scanFilePath;

    public function __constructor($scanfilepath){
        $this->scanFilePath = $scanfilepath;
    }
}