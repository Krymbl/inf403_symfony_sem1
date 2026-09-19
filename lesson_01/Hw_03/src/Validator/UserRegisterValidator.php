<?php
declare(strict_types=1);

namespace Hw_03\Validator;

use Hw_03\DTO\UserDto;

final readonly class UserRegisterValidator
{
    private const int EMAIL_MAX_LENGTH = 254;
    private const int NAME_MAX_LENGTH = 100;
    private const int AGE_MAX = 120;
    private const int AGE_MIN = 1;


    public function validate(UserDto $dto): array
    {
        $errors = [];

        $this->validateName($dto->name, $errors);
        $this->validateEmail($dto->email, $errors);
        $this->validateAge($dto->age, $errors);

        return $errors;
    }

    private function validateName(string $name, array &$errors): void
    {
        $name = trim($name);

        if ($name === "") {
            $errors["name"][] = "Имя обязательно";
            return;
        }

        if (mb_strlen($name) > self::NAME_MAX_LENGTH) {
            $errors["name"][] = "Длина имени максимум ".self::NAME_MAX_LENGTH;
            return;
        }

        if (preg_match('/^[\p{L} \-]+$/u', $name) !== 1) {
            $errors["name"][] = "Невалидное имя";
        }
    }

    private function validateEmail(string $email, array &$errors): void
    {
        $email = trim($email);

        if ($email === "") {
            $errors["email"][] = "Почта обязательна";
            return;
        }

        if (mb_strlen($email) > self::EMAIL_MAX_LENGTH) {
            $errors["email"][] = "Длина почты максимум ".self::EMAIL_MAX_LENGTH;
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"][] = "Невалидный email. Пример: example@gmail.com";
        }
    }

    private function validateAge(string $age, array &$errors): void
    {
        $age = trim($age);
        if ($age === "") {
            $errors["age"][] = "Возраст обязателен";
            return;
        }

        if (!ctype_digit($age)) {
            $errors['age'][] = 'Возраст должен быть целым числом';
            return;
        }

        $ageValue = (int)$age;
        if ($ageValue < self::AGE_MIN || $ageValue > self::AGE_MAX) {
            $errors["age"][] = "Возраст целое число от ".self::AGE_MIN." до ".self::AGE_MAX;
        }
    }
}