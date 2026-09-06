<?php

namespace Hw_01\Service;

use Hw_01\Exception\CalculatorValidationException;

final readonly class CalculatorService
{
    /**
     * @throws CalculatorValidationException
     */
    public function validateNumericInput(?string $input): void
    {
        if ($input === "" || $input === null) {
            throw new CalculatorValidationException("Ошибка: пустое занчение");
        }

        if (!is_numeric($input)) {
            throw new CalculatorValidationException("Ошибка: введено не число");
        }

    }

    /**
     * @throws CalculatorValidationException
     */
    public function validateOperatorInput(?string $input): void
    {
        if ($input === "" || $input === null) {
            throw new CalculatorValidationException("Ошибка: пустое значение");
        }

        if (!in_array($input, ["+", "-", "/", "*"], true)) {
            throw new CalculatorValidationException("Ошибка: такой оператор не доступен");
        }

    }

    /**
     * @throws CalculatorValidationException
     */
    public function calculate(float $first, float $second, string $operator): float
    {

        if ($operator === "/" && $second === 0.0) {
            throw new CalculatorValidationException("Ошибка: деление на 0 невозможно");
        }

        return match ($operator) {
            "+" => $first + $second,
            "-" => $first - $second,
            "/" => $first / $second,
            "*" => $first * $second,
            default => throw new CalculatorValidationException("Ошибка: такой оператор не доступен"),
        };
    }
}