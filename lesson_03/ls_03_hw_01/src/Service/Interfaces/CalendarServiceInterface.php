<?php

namespace App\Service\Interfaces;

use App\Dto\CalendarDto;
use DateTimeImmutable;

interface CalendarServiceInterface
{

    public function buildMonthGrid(CalendarDto $dto): array;

    public function initDate(?int &$year, ?int &$month): void;

    public function next(CalendarDto $dto): array;

    public function prev(CalendarDto $dto): array;

    public function getMonthName(int $month): string;

}
