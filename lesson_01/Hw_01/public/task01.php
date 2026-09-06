<?php

declare(strict_types=1);

use Hw_01\Service\CalculatorService;
use Hw_01\Service\InputService;
use Hw_01\Exception\CalculatorValidationException;
use Hw_01\Exception\InputException;

require_once __DIR__.'/../vendor/autoload.php';

$inputService = new InputService();
$calculatorService = new CalculatorService();

while (true) {
    try {
        echo "Введите первое число: ";
        $first = $inputService->getInput();
        $calculatorService->validateNumericInput($first);
        $first = (float)$first;

        echo "Введите второе число: ";
        $second = $inputService->getInput();
        $calculatorService->validateNumericInput($second);
        $second = (float)$second;

        echo "Введите оператор (+, -, /, *): ";
        $operator = $inputService->getInput();
        $calculatorService->validateOperatorInput($operator);

        $result = $calculatorService->calculate($first, $second, $operator);
        echo "Результат: ".$result."\n";
    } catch (InputException $e) {
        echo $e->getMessage() . ". Конец работы программы";
        break;
    } catch (CalculatorValidationException $e) {
        echo $e->getMessage(). ". Попробуйте заново" . PHP_EOL;
    }
}


