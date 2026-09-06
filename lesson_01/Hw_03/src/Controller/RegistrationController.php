<?php

declare(strict_types=1);

namespace Hw_03\Controller;

use Hw_03\Core\AbstractController;
use Hw_03\DTO\UserDto;
use Hw_03\Exception\SecurityException;
use Hw_03\Exception\ServerException;
use Hw_03\Exception\UserValidationException;
use Hw_03\Service\UserService;

final readonly class RegistrationController extends AbstractController
{

    private UserService $userService;
    public function __construct() {
        $this->userService = new UserService();
    }

    /**
     * @throws ServerException
     */
    public function showForm(): string
    {
        if ($this->getUser() !== null) {
            $this->setFlash("error", "Вы уже вошли");
            $this->redirect("/greeting");
        }
        return $this->render("greeting/form");
    }

    /**
     * @throws ServerException
     */
    public function register(): string
    {
        if ($this->getUser() !== null) {
            $this->setFlash("error", "Вы уже вошли");
            return $this->render("greeting/index");
        }

        $dto = new UserDto();

        try {
            $this->validateCsrfToken();

            $name = trim($_POST["name"] ?? "");
            $email = mb_strtolower(trim($_POST["email"] ?? ""));
            $age = trim($_POST["age"] ?? "");

            $dto->name = $name;
            $dto->email = $email;
            $dto->age = $age;

            $this->userService->register($dto);

        } catch (SecurityException $e) {
            $this->setFlash("error", $e->getMessage());
            $this->redirect("form");

        } catch (UserValidationException $e) {
            return $this->render(
                "greeting/form",
                [
                    "dto" => $dto,
                    "errors" => $e->getErrors(),
                ]
            );
        }

        $this->setFlash("success","Успешная регистрация");
        $this->redirect("/greeting");
    }

    public function logout(): void
    {
        try {
            $this->validateCsrfToken();

            $this->userService->logout();
        } catch (SecurityException $e) {
            $this->setFlash("error", $e->getMessage());
        }

        $this->redirect("/");
    }
}