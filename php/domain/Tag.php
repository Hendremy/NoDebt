<?php

namespace NoDebt;

class Tag
{
    public $tag;
    public $gid;
    public $did;

    public function __construct($tag, $gid){
        $this->tag = $tag;
        $this->gid = $gid;
    }
}