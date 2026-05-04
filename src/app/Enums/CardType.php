<?php

namespace App\Enums;

enum CardType: string
{
    case LEADER = 'LEADER';
    case CHARACTER = 'CHARACTER';
    case EVENT = 'EVENT';
    case STAGE = 'STAGE';
}
