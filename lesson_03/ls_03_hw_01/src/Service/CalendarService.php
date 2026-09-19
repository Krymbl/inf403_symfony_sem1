<?php

namespace App\Service;

use App\Dto\CalendarDto;
use App\Exception\CalendarException;
use App\Service\Interfaces\CalendarServiceInterface;
use DateTimeImmutable;

final readonly class CalendarService implements CalendarServiceInterface
{
    const int YEAR_RANGE = 5;

    /**
     * @throws CalendarException
     */
    public function buildMonthGrid(CalendarDto $dto): array
    {
        $startMonth = new DateTimeImmutable("{$dto->year}-{$dto->month}-01");
        $endMonth = (clone $startMonth)->modify("last day of this month");

        $month = array_fill(0, (int)$startMonth->format("N") - 1, null);

        for ($i = $startMonth; $i <= $endMonth; $i = $i->modify("+1 day")) {

            $month[] = [
                'day' => (int) $i->format('d'),
                'isWeekend' => $this->isWeekend($i),
                'title' => $this->getTitle($i),
            ];
        }

        $month = array_merge($month, array_fill(0, 7 - (int)$endMonth->format("N"), null));

        return array_chunk($month, 7);
    }

    public function initDate(?int &$year, ?int &$month): void
    {
        $currentYear = (int)date('Y');
        $currentMonth = (int)date('m');

        $year ??= $currentYear;
        $month ??= $currentMonth;

        $year = max(min($year, $currentYear + self::YEAR_RANGE), $currentYear - self::YEAR_RANGE);
        $month = max(min($month, 12), 1);
    }


    public function next(CalendarDto $dto): array
    {
        $year = $dto->year;
        $month = $dto->month;

        $month++;

        if ($month > 12) {
            $year++;
            $month = 1;
        }

        $this->initDate($year, $month);

        return [
            'year' => $year,
            'month' => $month,
        ];
    }

    public function prev(CalendarDto $dto): array
    {
        $year = $dto->year;
        $month = $dto->month;

        $month--;

        if ($month < 1) {
            $year--;
            $month = 12;
        }

        $this->initDate($year, $month);

        return [
            'year' => $year,
            'month' => $month,
        ];
    }

    /**
     * @throws CalendarException
     */
    public function getMonthName(int $month): string
    {
        return match ($month) {
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
            default => throw new CalendarException("У такого месяца: $month нет Названия "),
        };
    }

    private function isWeekend(\DateTimeInterface $date): bool
    {
        return $date->format('N') > 5;
    }

    /**
     * @throws CalendarException
     */
    private function getTitle(\DateTimeInterface $date): string
    {
        return match ((int)$date->format("N")) {
                1 => 'Пн, ',
                2 => 'Вт, ',
                3 => 'Ср, ',
                4 => 'Чт, ',
                5 => 'Пт, ',
                6 => 'Сб, ',
                7 => 'Вс, ',
                default => throw new CalendarException(
                    "У такого дня: {$date->format('d-m-Y')} нет Названия"
                ),
            }.$date->format('d-m-Y');
    }
}
