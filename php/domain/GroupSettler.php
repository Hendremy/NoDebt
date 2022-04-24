<?php

namespace NoDebt;

class GroupSettler
{
    private $group;

    public function __construct($group){
        $this->group = $group;
    }

    public function settleGroup(){
        $this->group->avgExp = $this->group->total / count($this->group->participants);
        foreach ($this->group->participants as $participant){
            $participant->groupTotalDiff = $participant->total - $this->group->avgExp;
        }
        $debtors = array_filter($this->group->participants, array($this, 'debtorFilter'));
        $creditors = array_filter($this->group->participants, array($this,'creditorFilter'));
    }

    private function debtorFilter($participant){
        return $participant->groupTotalDiff < 0;
    }

    private function creditorFilter($participant){
        return $participant->groupTotalDiff > 0;
    }

    private function sortByDiff($part1, $part2){

    }
}