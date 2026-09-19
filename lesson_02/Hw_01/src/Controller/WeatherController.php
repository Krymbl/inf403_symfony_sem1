<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Controller;

use Ls_02_Hw_01\Core\AbstractController;
use Ls_02_Hw_01\Exception\ApiException;
use Ls_02_Hw_01\Exception\ServerException;
use Ls_02_Hw_01\Service\WeatherService;

final readonly class WeatherController extends AbstractController
{
    private WeatherService $weatherService;

    public function __construct()
    {
        $this->weatherService = new WeatherService();
    }

    /**
     * @throws ServerException
     */
    public function index(): string
    {
        return $this->render("index");
    }

    public function getFromApi(): string
    {
        try {
            $city = trim($_GET["city"] ?? "Казань");
            $jsonData = $this->weatherService->getWeatherLikeJson($city);
            $result = $this->weatherService->postInEmulator($jsonData);
            return "первоначальные данные = \n". $jsonData . " \nС эмулятора = \n". json_encode($result, JSON_THROW_ON_ERROR);
        } catch (ApiException|\JsonException $e) {
            $this->setFlash("error", $e->getMessage());
            $this->redirect("/");
        }
    }

}