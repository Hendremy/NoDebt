<?php

namespace NoDebt;

class Link
{

    const origin = "http://192.168.128.13/~e190449/EVAL_V4/";

    public static function to($link){
        return self::origin.$link;
    }
}