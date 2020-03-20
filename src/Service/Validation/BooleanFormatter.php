<?php

namespace App\Service\Validation;

class BooleanFormatter
{
    public function booleanFormatter($booleanString)
    {
        if (false !== strpos($booleanString, 'yes')) {
            return date('Y/m/d');
        }

        return $booleanString = strtolower(preg_replace('/[^a-zA-Z]/', '', $booleanString));
    }
}
