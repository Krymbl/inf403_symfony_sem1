<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\StudentDto;
use App\Form\StudentType;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/student', name: 'student_')]
final class StudentController extends AbstractController
{

    public function __construct(
        private readonly StudentService $studentService
    ) {
    }

    #[Route(path: '/grades', name: 'grades', methods: ['GET'])]
    public function grades(): Response
    {
        $students = $this->studentService->getAllWithGrades();

        return $this->render(
            'student/grades.html.twig',
            [
                'students' => $students,
            ]
        );
    }

    #[Route(path: '/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $dto = new StudentDto();
        $form = $this->createForm(StudentType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $this->studentService->create($dto);
            $this->addFlash('success', "Студент {$student->getFullName()} Создан!");

            return $this->redirectToRoute('student_grades');
        }

        return $this->render(
            'student/save.html.twig',
            [
                'form' => $form,
                'title' => 'Новый студент',
            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request): Response
    {
        $student = $this->studentService->get($id);
        $dto = StudentDto::fromStudent($student);
        $form = $this->createForm(StudentType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studentService->update($student, $dto);
            $this->addFlash('success', "Студент {$student->getFullName()} изменён!");

            return $this->redirectToRoute('student_grades');
        }

        return $this->render(
            'student/save.html.twig',
            [
                'form' => $form,
                'title' => 'Редактирование студента',
            ]
        );
    }

    #[Route(path: '/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        $student = $this->studentService->get($id);
        if (!$this->isCsrfTokenValid('delete-student', $request->request->getString('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $this->studentService->delete($student);

        $this->addFlash('success', 'Студент Удален!');

        return $this->redirectToRoute('student_grades');
    }
}
