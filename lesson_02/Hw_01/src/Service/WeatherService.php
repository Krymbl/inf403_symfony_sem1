<?php

declare(strict_types=1);

namespace Ls_02_Hw_01\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Ls_02_Hw_01\Exception\ApiException;
use Ls_02_Hw_01\Exception\ServerException;

final class WeatherService
{
    private Client $client;
    private Client $postClient;
    private string $apiKey;
    private string $apiUrl;

    private string $jsonEmulatorUrl;

    public function __construct()
    {
        $this->apiKey = $_ENV["WEATHER_API_KEY"];
        $this->apiUrl = $_ENV["WEATHER_API_URL"];
        $this->jsonEmulatorUrl = $_ENV["JSON_EMULATOR_URL"];

        $this->client = new Client([
            "base_uri" => "$this->apiUrl",
            "timeout" => 2.0,
            "headers" => [
                "Accept" => "application/json; charset=UTF-8",
            ],
        ]);

        $this->postClient = new Client([
            "base_uri" => "$this->jsonEmulatorUrl",
            "timeout" => 2.0,
            "headers" => [
                "Accept" => "application/json; charset=UTF-8",
            ],
        ]);
    }

    /**
     * @throws ApiException
     * @throws ServerException
     */
    public function getWeatherLikeJson(string $city): string
    {
        $data = $this->getWeatherFromApi($city);
        $processedData = $this->extractMainFields($data);

        $jsonData = json_encode($processedData);

        if (!$jsonData) {
            throw new ServerException("Ошибка при кодировании массива - Сервис Погоды API");
        }

        return $jsonData;

    }

    /**
     * @throws ApiException
     */
    public function postInEmulator(string $payload): array
    {
        try {
            $response = $this->postClient->request("POST", "", [
                "body" => $payload,
                "headers" => [
                    "Content-Type" => "application/json",
                ],
            ]);

            $code = $response->getStatusCode();
            if ($code < 200 || $code >= 300) {
                throw new ApiException("Ответ от сервиса-эмулятора 'Не успешно'");
            }

            return json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (GuzzleException $e) {
            throw new ApiException("Проблема подключения к сервису-эмулятору", 0, $e);
        } catch (\JsonException $e) {
            throw new ApiException("Некорректный ответ от сервиса-эмулятора", 0, $e);
        }
    }

    /**
     * @throws ApiException
     */
    private function getWeatherFromApi(string $city): array
    {
        try {
            $response = $this->client->request('GET', "", [
                "query" => [
                    "q" => $city,
                    "appid" => $this->apiKey,
                    "units" => "metric",
                ],
            ]);

            $code = $response->getStatusCode();
            if ($code < 200 || $code >= 300) {
                throw new ApiException("Ответ от стороннего сервеса 'Не успешно', попробуйте заново позже");
            }

            return array_merge(["status_code" => $code],
                json_decode(
                    $response->getBody()->getContents(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        } catch (GuzzleException $e) {
            throw new ApiException("Проблема подключения к стороннему сервису погоды", 0, $e);
        } catch (\JsonException $e) {
            throw new ApiException("Некорректный ответ от сервиса погоды - невалидный json", 0, $e);
        }
    }

    private function extractMainFields(array $data): array
    {
        return [
            "status_code" => $data["status_code"],
            "weather_description" => $data["weather"][0]["description"] ?? null,
            "temp" => $data["main"]["temp"] ?? null,
            "feels_like" => $data["main"]["feels_like"] ?? null,
            "temp_min" => $data["main"]["temp_min"] ?? null,
            "temp_max" => $data["main"]["temp_max"] ?? null,
            "pressure" => $data["main"]["pressure"] ?? null,
            "humidity" => $data["main"]["humidity"] ?? null,
            "wind_speed" => $data["wind"]["speed"] ?? null,
        ];
    }
}