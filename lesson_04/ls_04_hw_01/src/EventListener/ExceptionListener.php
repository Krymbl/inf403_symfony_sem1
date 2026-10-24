<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\AbstractBusinessException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

#[AsEventListener(event: KernelEvents::EXCEPTION)]
final readonly class ExceptionListener
{
    public function __construct(
        private Environment $twig,
        #[Autowire('%kernel.debug%')] private bool $debug,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $throwable = $event->getThrowable();

        $statusCode = $this->statusCode($throwable);
        $message = $this->message($throwable, $statusCode);

        if (!$this->wantsJson($request)) {
            if ($this->debug) {
                return;
            }

            $response = $this->htmlResponse($statusCode, $message);
        } else {
            $response = $this->jsonResponse($statusCode, $message);
        }

        if ($throwable instanceof HttpExceptionInterface) {
            $response->headers->add($throwable->getHeaders());
        }

        $event->setResponse($response);
    }

    private function statusCode(\Throwable $throwable): int
    {
        return $throwable instanceof HttpExceptionInterface
            ? $throwable->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function message(\Throwable $throwable, int $statusCode): string
    {
        if ($throwable instanceof AbstractBusinessException) {
            return $throwable->getMessage();
        }

        return match ($statusCode) {
            Response::HTTP_BAD_REQUEST => 'Неверный запрос',
            Response::HTTP_FORBIDDEN => 'Доступ запрещён',
            Response::HTTP_NOT_FOUND => 'Страница не найдена',
            Response::HTTP_METHOD_NOT_ALLOWED => 'Метод не разрешён',
            default => 'Внутренняя ошибка сервера',
        };
    }

    private function wantsJson(Request $request): bool
    {
        return $request->isXmlHttpRequest()
            || str_contains($request->headers->get('Accept', ''), 'application/json');
    }

    private function htmlResponse(int $statusCode, string $message): Response
    {
        $html = $this->twig->render(
            'error/error.html.twig',
            [
                'statusCode' => $statusCode,
                'message' => $message,
            ]
        );

        return new Response($html, $statusCode);
    }

    private function jsonResponse(int $statusCode, string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'success' => false,
                'error' => $message,
            ],
            $statusCode,
        );
    }
}
