<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\MailGenerationDto;
use App\Dto\MailRecipientDto;
use App\Form\MailGenerationType;
use App\Service\MailGenerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MailGenerationController extends AbstractController
{
    public function __construct(
        private readonly MailGenerationService $mailGenerationService,
    ) {
    }

    #[Route(path: '', name: 'mail_generate', methods: ['GET', 'POST'])]
    public function generate(Request $request): Response
    {
        $recipientCount = min(100, max(1, $request->query->getInt('recipients', 1)));
        $dto = new MailGenerationDto();

        for ($i = 0; $i < $recipientCount; $i++) {
            $dto->recipients[] = new MailRecipientDto();
        }

        $form = $this->createForm(MailGenerationType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $this->mailGenerationService->generate($dto->recipients);

            return $this->render('mail/report.html.twig', [
                'files' => $files,
            ]);
        }

        return $this->render('mail/generate.html.twig', [
            'form' => $form,
            'recipientCount' => max(1, count($form->get('recipients'))),
        ]);
    }
}
