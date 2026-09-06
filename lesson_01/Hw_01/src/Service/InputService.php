<?php

namespace Hw_01\Service;

use Hw_01\Exception\InputException;

final readonly class InputService
{
    /**
     * @throws InputException
     */
    public function getInput(): string
    {
        $input = fgets(STDIN);

        if ($input === false) {
            throw new InputException("Ошибка: закрыт поток ввода");
        }

        return trim($input);
    }

}