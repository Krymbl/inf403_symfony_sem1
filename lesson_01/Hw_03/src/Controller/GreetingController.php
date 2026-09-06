<?php

declare(strict_types=1);

namespace Hw_03\Controller;

use Hw_03\Core\AbstractController;
use Hw_03\Exception\ServerException;

final readonly class GreetingController extends AbstractController
{

    /**
     * @throws ServerException
     */
    public function index(): string
    {
        $user = $this->getUser();

        return $this->render(
            'greeting/index',
            [
                'user' => $user,
            ]
        );
    }

}