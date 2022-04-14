<?php

namespace NoDebt;

use NumberFormatter;

class CurrencyFormatter
{
    const locale = 'fr_FR';

    /*TODO: Décommenter cette partie de code pour le déploiement Dartagnan (money_format pas disponible sur windows)
    et voir pour les symboles yen & pounds pq ne s'affiche pas
     * /
    /*public function formatCurrency($amount, $currency){
        $amout = floatval($amount);
        setLocale(LC_MONETARY, $this->getCurrencyLocale($currency));
        return money_format('%n',$amount);
    }*/

    public function formatCurrency($amount, $currency){
        $amount = floatval($amount);
        $symbol = $this->getCurrencySymbol($currency);
        return number_format($amount, 2, ',', ' ') . ' ' . utf8_encode($symbol);
    }

    public function getCurrencySymbol($currencyCode){
        switch ($currencyCode){
            case 'EUR': return '&euro;';
            case 'JPY': return '&yen;';
            case 'GBP': return '&pound;';
            case 'USD': return '&dollar;';
            default: return '?';
        }
    }

    public function getCurrencyLocale($currency){
        switch ($currency){
            case 'JPY': return 'ja_JP';
            case 'GBP': return 'en_GB';
            case 'USD': return 'en_US';
            default: return 'fr_FR';
        }
    }
}