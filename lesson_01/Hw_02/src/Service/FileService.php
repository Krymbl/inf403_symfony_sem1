<?php

namespace Hw_02\Service;

use Hw_02\Exception\InvalidFileException;
use Hw_02\Exception\InvalidFileFormatException;

final class FileService
{

    /**
     * @throws InvalidFileException
     */
    public function readDataFromFileLikeLines(string $filePath): array
    {

        if (!$filePath) {
            throw new InvalidFileException("Путь файла передан пустым: $filePath");
        }

        if (!file_exists($filePath)) {
            throw new InvalidFileException("Файл не найден по пути $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            throw new InvalidFileException("Не удалось считать файл по пути $filePath");
        }

        return $lines;
    }

    /**
     * @throws InvalidFileFormatException
     */
    public function parseLinesToArray(array $lines, ?int $requiredElementsInLine = null): array
    {
        $result = [];
        foreach ($lines as $lineNumber =>$line) {
            $lineNumber++;
            $data = explode(";", $line);

            if (empty($line)) {
                throw new InvalidFileFormatException("Пустая строка $lineNumber");
            }
            if ($requiredElementsInLine !== null
                && $requiredElementsInLine > 0
                && count($data) !== $requiredElementsInLine) {
                throw new InvalidFileFormatException(
                    "Неправильный формат файла, в строке должно быть ".
                    "$requiredElementsInLine элемент(ов) разделенных ';'. Строка $lineNumber",);
            }

            $data = array_map(fn($item) => trim($item), $data);

            $result[] = $data;
        }

        return $result;
    }
}