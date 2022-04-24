<?php

namespace NoDebt;

require_once 'php/domain/Payment.php';

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
        $debtors = array_values(array_filter($this->group->participants, array($this, 'debtorFilter')));
        $creditors = array_values(array_filter($this->group->participants, array($this,'creditorFilter')));

        //Calcul des virements
        $payments = array();

        while(count($debtors) > 0 || count($creditors) > 0){//Tant qu'il y a des comptes à régler
            $amount = null;
            $creditor = null;
            $debtor = null;
            //Recherche d'un montant débiteur égal à un montant créditeur
            $oppositeAmounts = $this->findOppositeAmounts($debtors, $creditors);
            //Si trouvé, on ajoute directement le virement
            if($oppositeAmounts){
                $creditor = $oppositeAmounts['cred'];
                $debtor = $oppositeAmounts['debt'];
                $amount = $creditor->groupTotalDiff;
            }else{//Sinon, recherche du plus grand créditeur & plus grand débiteur
                $creditor = $this->findTopCreditor($creditors);
                $debtor = $this->findTopDebtor($debtors);
                $amount = min($creditor->groupTotalDiff,$debtor->groupTotalDiff);
            }
            $payment = new Payment($debtor->uid, $creditor->uid, $amount);
            //Mise à jour des montants
            $debtor->groupTotalDiff += $payment->amount;
            $creditor->groupTotalDiff -= $payment->amount;
            //Ajout du virement au tableau
            $payments[] = $payment;

            echo '<br>Eeeeee <br>';
            var_dump($creditor);
            echo '<br>';
            var_dump($debtor);
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
        return array_filter($participants, array($this,'accountSettled'));
    }

    private function accountSettled($participant){
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

    private function findTopCreditor($creditors){
        $max = $creditors[0];
        foreach($creditors as $creditor){
            if($creditor->groupTotalDiff > $max->groupTotalDiff){
                $max = $creditor;
            }
        }
        return $max;
    }

    private function findTopDebtor($debtors){
        $min = $debtors[0];
        foreach($debtors as $debtor){
            if($debtor->groupTotalDiff < $min->groupTotalDiff){
                $min = $debtor;
            }
        }
        return $min;
    }
}