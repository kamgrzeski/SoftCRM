<?php

namespace App;

class GlobalFunctions
{
    public static function getPrioritySize()
    {
        $sizeFromConfig = config('crm_settings.priority_size');
        $arrayFromIteration = [];

        for($i = 1; $i <= $sizeFromConfig; $i++) {
            $arrayFromIteration[] = $i;
        }
        return $arrayFromIteration;
    }
}
