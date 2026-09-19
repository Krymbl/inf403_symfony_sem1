<?php

namespace App\Dto;

final readonly class CalendarDto
{

    public function __construct(
        public int $year,
        public int $month,
    ) {
    }

}
