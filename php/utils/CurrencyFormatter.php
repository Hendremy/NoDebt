<?php

namespace NoDebt;

use NumberFormatter;

class CurrencyFormatter
{
    const locale = 'fr_FR';

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