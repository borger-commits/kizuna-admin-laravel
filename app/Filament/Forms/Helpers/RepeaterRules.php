<?php

namespace App\Helpers; // 👈 Updated namespace to match the folder

use Filament\Forms\Components\Repeater;

class RepeaterRules
{
    public static function isMoreThanOne(): \Closure
    {
        return function (Repeater $component) {
            $rows = $component->getState() ?? [];

            return count($rows) > 1;
        };
    }
}
