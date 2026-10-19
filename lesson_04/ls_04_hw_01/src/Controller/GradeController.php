<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\GradeDto;
use App\Entity\Grade;
use App\Entity\Student;
use App\Form\GradeType;
use App\Service\GradeService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/grade', name: 'grade_')]
final class GradeController extends AbstractController
{
    public function __construct(
        private readonly GradeService $gradeService,
    ) {
    }

    #[Route(path: '/{studentId}/create', name: 'create', requirements: ['studentId' => '\d+'], methods: ['POST'])]
    public function create(
        #[MapEntity(id: 'studentId')] Student $student,
        Request $request,
    ): JsonResponse {
        return $this->save($request, new GradeDto(), $student);
    }

    #[Route(path: '/{id}/edit', name: 'edit', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function edit(Grade $grade, Request $request): JsonResponse
    {
        return $this->save($request, GradeDto::fromGrade($grade), $grade->getStudent(), $grade);
    }

    #[Route(path: '/{id}/delete', name: 'delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Grade $grade, Request $request): JsonResponse
    {
        $id = $grade->getId();
        $studentId = $grade->getStudent()->getId();

        if (!$this->isCsrfTokenValid('delete-grade-'.$id, $request->request->getString('_token'))) {
            return $this->json(
                [
                    'success' => false,
                    'error' => 'Неверный CSRF-токен',
                ],
                Response::HTTP_FORBIDDEN,
            );
        }

        $this->gradeService->delete($grade);

        return $this->json(
            [
                'success' => true,
                'id' => $id,
                'studentId' => $studentId,
            ]
        );
    }

    private function save(Request $request, GradeDto $dto, Student $student, ?Grade $grade = null): JsonResponse
    {
        $form = $this->createForm(GradeType::class, $dto);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->json(
                ['success' => false, 'errors' => ['_form' => ['Данные не отправлены']]],
                Response::HTTP_BAD_REQUEST,
            );
        }

        if (!$form->isValid()) {
            return $this->json(
                ['success' => false, 'errors' => $this->formErrors($form)],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        $grade = $grade !== null
            ? $this->gradeService->update($grade, $dto)
            : $this->gradeService->create($dto);

        return $this->json([
            'success' => true,
            'message' => 'Оценка '.$grade->getValue()->value.' проставлена',
            'id' => $grade->getId(),
            'value' => $grade->getValue()->value,
            'studentId' => $grade->getStudent()->getId(),
        ]);
    }

    private function formErrors(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors['_form'][] = $error->getMessage();
        }

        foreach ($form->all() as $name => $child) {
            foreach ($child->getErrors() as $error) {
                $errors[$name][] = $error->getMessage();
            }
        }

        return $errors;
    }
}
