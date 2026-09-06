<?php

namespace Hw_02\Service;

use Hw_02\Exception\InvalidStudentsDataException;

final readonly class StudentsService
{

    /**
     * @throws InvalidStudentsDataException
     */
    public function avgGradePerStudent(array $data): array
    {
        $this->checkData($data);
        $students = [];
        $bestStudents = [];
        $bestAvgGrade = 0;
        foreach ($data as $studentData) {
            $name = $studentData[0];
            $gradeArray = explode(",", $studentData[1]);

            $sumGrad = array_reduce($gradeArray, function ($carry, $item) {
                return $carry + $item;
            }, 0);

            $avgGrade = ($sumGrad / count($gradeArray));

            if ($avgGrade > $bestAvgGrade) {
                $bestStudents = [];
                $bestStudents[] = $name;
                $bestAvgGrade = $avgGrade;
            } elseif ($avgGrade === $bestAvgGrade) {
                $bestStudents[] = $name;
                $bestAvgGrade = $avgGrade;
            }

            $students[] = [
                "name" => $name,
                "avgGrade" => sprintf("%.2f" ,round($avgGrade, 2))
            ];

        }

        return [
            "students" => $students,
            "bestStudents" => $bestStudents
            ];
    }

    /**
     * @throws InvalidStudentsDataException
     */
    private function checkData(array $data): void
    {
        if (empty($data)) {
            throw new InvalidStudentsDataException("Данные о студентах пустые");
        }

        foreach ($data as $lineNumber => $studentData) {;
            ++$lineNumber;
            if (empty($studentData)) {
                throw new InvalidStudentsDataException(
                    "Нет данных о студенте в строке $lineNumber"
                );
            }

            if (count($studentData) !== 2) {
                throw new InvalidStudentsDataException(
                    "Должно быть 2 элемента - Имя и Оценки в строке $lineNumber"
                );
            }

            $name = $studentData[0];
            $grades = $studentData[1];

            if (!$name && !is_string($name) || preg_match('/\d/', $name)) {
                throw new InvalidStudentsDataException(
                    "Имя студента невалидное, должны быть символы без цифр - 1 элемент в строке $lineNumber"
                );
            }

            if (!$grades) {
                throw new InvalidStudentsDataException(
                    "Оценки студента невалидные - 2 элемент в строке $lineNumber"
                );
            }
        }
    }
}