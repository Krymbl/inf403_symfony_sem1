<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\StudentDto;
use App\Entity\Student;
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
        $students = $this->studentService->getAll();

        return $this->render(
            'student/grades.html.twig',
            [
                'students' => $students,
            ]
        );
    }

    #[Route(path: '/create', name: 'create_form', methods: ['GET'])]
    public function showCreateForm(): Response
    {
        $form = $this->createForm(StudentType::class, new StudentDto());

        return $this->render(
            'student/create.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dto = new StudentDto();
        $form = $this->createForm(StudentType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studentService->create($dto);
            $this->addFlash('success', 'Студент Создан!');

            return $this->redirectToRoute('student_grades');
        }

        return $this->render(
            'student/create.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'update_form', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEditForm(Student $student): Response
    {
        $form = $this->createForm(StudentType::class, StudentDto::fromStudent($student));

        return $this->render(
            'student/edit.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'update', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function edit(Student $student, Request $request): Response
    {
        $dto = StudentDto::fromStudent($student);
        $form = $this->createForm(StudentType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studentService->update($student, $dto);

            $this->addFlash('success', 'Студент Изменен!');

            return $this->redirectToRoute('student_grades');
        }

        return $this->render(
            'student/edit.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Student $student, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('delete-student-'.$student->getId(), $request->request->getString('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $this->studentService->delete($student);

        $this->addFlash('success', 'Студент Удален!');

        return $this->redirectToRoute('student_grades');
    }
}
