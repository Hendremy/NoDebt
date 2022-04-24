<?php

namespace NoDebt;

class GroupSettler
{
    private $group;

    public function __construct($group){
        $this->group = $group;
    }

    public function settleGroup(){
        //Calcul dépense moyenne
        $this->group->avgExp = $this->group->total / count($this->group->participants);
        //Calcul des différences à la moyenne pour chaque participant
        foreach ($this->group->participants as $participant){
            $participant->groupTotalDiff = $participant->total - $this->group->avgExp;
        }
        //Tri des participants:
        // débiteur -> diff à la moyenne négative (doivent de l'argent)
        // créditeur -> diff à la moyenne positive (reçoivent de l'argent)
        // si diff à la moyenne = 0, compte réglé
        $debtors = array_filter($this->group->participants, array($this, 'debtorFilter'));
        $creditors = array_filter($this->group->participants, array($this,'creditorFilter'));

        //Calcul des virements
        $payments = array();

        while(count($debtors) > 0 && count($creditors) > 0){//Tant qu'il y a des comptes à régler
            $payment = null;
            $creditor = null;
            $debtor = null;
            //Recherche d'un montant débiteur égal à un montant créditeur
            $oppositeAmounts = $this->findOppositeAmounts($debtors, $creditors);
            //Si trouvé, on ajoute directement le virement
            if($oppositeAmounts){
                $creditor = $oppositeAmounts['cred'];
                $debtor = $oppositeAmounts['debt'];
                $payment = new Payment($debtor->uid, $creditor->uid, $creditor->groupTotalDiff);
            }else{//Sinon, recherche d'un créditeur & débiteur

            }
            //Mise à jour des montants
            $debtor->groupTotalDiff += $payment->amount;
            $creditor->groupTotalDiff -= $payment->amount;
            //Ajout du virement au tableau
            $payments[] = $payment;
            //On enlève les participants pour qui leur compte est réglé
            $debtors = $this->clear($debtors);
            $creditors = $this->clear($creditors);
        }
        return $payments;
    }

    private function debtorFilter($participant){
        return $participant->groupTotalDiff < 0;
    }

    private function creditorFilter($participant){
        return $participant->groupTotalDiff > 0;
    }

    private function clear($participants){
        return array_filter($participants, array($this,'diffIsNotZero'));
    }

    private function diffIsNotZero($participant){
        return $participant->groupTotalDiff != 0;
    }

    private function findOppositeAmounts($debtors, $creditors){
        foreach ($creditors as $creditor){
            foreach ($debtors as $debtor){
                if($creditor->groupTotalDiff + $debtor->groupTotalDiff == 0){
                    return ['cred' => $creditor, 'debt' => $debtor];
                }
            }
        }
        return false;
    }
}