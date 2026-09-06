<?php

use Hw_02\Core\Config;
use Hw_02\Exception\ConfigException;
use Hw_02\Exception\FileException;
use Hw_02\Exception\InvalidStudentsDataException;
use Hw_02\Service\FileService;
use Hw_02\Service\StudentsService;

require_once __DIR__ . '/../vendor/autoload.php';
const ROOT_DIR = __DIR__ . "/../";

try {
    Config::load(ROOT_DIR);

    $filePath = $_ENV['FILE_PATH'];
    $fileService = new FileService();

    $lines = $fileService->readDataFromFileLikeLines(ROOT_DIR . $filePath);

    $data = $fileService->parseLinesToArray($lines, 2);

    $studentService = new StudentsService();
    $studentsData = $studentService->avgGradePerStudent($data);
} catch (ConfigException|FileException|InvalidStudentsDataException $e) {
    echo $e->getMessage();
    exit;
}

foreach ($studentsData["students"] as $studentData) {
    echo $studentData["name"].": ".$studentData["avgGrade"]."\n";
}

echo PHP_EOL."Лучший студент(ы):".PHP_EOL;
foreach ($studentsData["bestStudents"] as $studentData) {
    echo $studentData.PHP_EOL;
}
