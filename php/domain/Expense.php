<?php

namespace NoDebt;

class Expense
{
    public $did;
    public $montant;
    public $paydate;
    public $libelle;
    public $uid;
    public $gid;
    public $groupname;
    public $spender;
    public $tagsString;
    public $tagsTab;

    public function implodeTags(){
        return implode(',', $this->tagsTab);
    }

    public function explodeTags(){
        return explode(',', $this->tagsString);
    }

}