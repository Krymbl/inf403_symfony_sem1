<?php
declare(strict_types=1);

namespace Ls_02_Hw_01\Controller;

final readonly class ErrorController
{
    public static function internalError(?string $message = null): string
    {
        return self::render(500, 'error/500', $message);
    }

    public static function notFound(?string $message = null): string
    {
        return self::render(404, 'error/404', $message);
    }

    private static function render(int $status, string $template, ?string $message = null): string
    {
        $templatePath = ROOT_DIR.'/templates/'.$template.'.php';
        $message = self::e($message ?? '');

        ob_start();

        if (file_exists($templatePath)) {
            require $templatePath;
        } else {
            echo "<h1>$status</h1> <p>Сообщение об ошибке:</p>" . $message;
        }

        return ob_get_clean();
    }

    public static function e(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
