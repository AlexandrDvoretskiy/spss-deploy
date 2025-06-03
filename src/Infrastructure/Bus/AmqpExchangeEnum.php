<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case AddSkills = 'add_skills';
}
