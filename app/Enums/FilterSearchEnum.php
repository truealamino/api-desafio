<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class FilterSearchEnum extends Enum
{
    const all = 0;
    const byName = 1;
    const byCode = 2;
    const byCurrencies = 3;
}
