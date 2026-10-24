<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongPasswordValidator extends ConstraintValidator
{

    public function validate(mixed $dto, Constraint $constraint): void
    {
        $password = $dto->password;

        if (!$password) {
            return;
        }

        $lower = mb_strtolower($password);

        if ($lower === mb_strtolower((string) $dto->name) || $lower === mb_strtolower((string) $dto->email)) {
            $this->addError('Пароль не должен совпадать с именем или почтой');
        }

        if (count(array_unique(mb_str_split($password))) === 1) {
            $this->addError('Пароль не может состоять из одинаковых символов');
        }

        if (preg_match_all('/\d/u', $password) < 2) {
            $this->addError('В пароле должно быть минимум 2 цифры');
        }

        if (preg_match_all('/\p{L}/u', $password) < 3) {
            $this->addError('В пароле должно быть минимум 3 буквы');
        }

        if (preg_match_all('/[^\p{L}\d]/u', $password) < 1) {
            $this->addError('В пароле должен быть минимум 1 спецсимвол');
        }
    }

    private function addError(string $message): void
    {
        $this->context->buildViolation($message)->atPath('password')->addViolation();
    }
}
