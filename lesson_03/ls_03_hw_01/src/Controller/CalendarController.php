<?php

namespace App\Controller;

use App\Dto\CalendarDto;
use App\Exception\CalendarException;
use App\Service\CalendarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: ['/','/calendar'], name: 'calendar_')]
final class CalendarController extends AbstractController
{

    public function __construct(
        private CalendarService $calendarService
    ) {
    }

    #[Route(path: '/', name: 'index')]
    public function index(Request $request): Response
    {
        if ($request->query->has('format')) {
            $year = $request->query->get('year') ?: null;
            $month = $request->query->get('month') ?: null;

            $this->calendarService->initDate($year, $month);

            return $this->redirectToRoute('calendar_show', [
                'format' => $request->query->get('format', 'table'),
                'year' => $year,
                'month' => $month,
            ]);
        }
        return $this->render('calendar/index.html.twig');
    }

    #[Route(
        path: '/{format<table|list|table-weekends>?table}/{year<\d{4}>?}/{month<\d{1,2}>?}',
        name: 'show'
    )]
    public function show(string $format, ?int $year, ?int $month): Response
    {
        $this->calendarService->initDate($year, $month);

        $dto = new CalendarDTO($year, $month);

        try {
            return $this->render("calendar/show.html.twig", [
                'format' => $format,
                'weeks' => $this->calendarService->buildMonthGrid($dto),
                'year' => $year,
                'month' => $month,
                'month_name' => $this->calendarService->getMonthName($month),
                'next' => $this->calendarService->next($dto),
                'prev' => $this->calendarService->prev($dto),
            ]);

        } catch (CalendarException $e) {
            return $this->render('calendar/error.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
