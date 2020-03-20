<?php

namespace App\Service\Validation;

class NumberFormatter
{
    //Price and Stock formatter
    public function numberFormatter($number)
    {
        $number = preg_replace('/[^0-9.]/', '', $number);

        return $number;
    }

    //set number to price format
    public function setPriceFormat($price)
    {
        return number_format($price);
    }
}
