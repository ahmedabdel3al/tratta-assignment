<?php

namespace App\Services\Communication\Twilio;

use App\Services\Communication\Contract\CommunicationProviderInterface;
use Illuminate\Support\Facades\Http;

class Twilio implements CommunicationProviderInterface
{
    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return config('communication.providers.twilio.api_url');
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return config('communication.providers.twilio.secret_token');
    }


    public function getUsageRecords(string $accountNumber, string $startDate, string $endDate, array $fees = []): array
    {
        $queryParameters = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'account_number' => $accountNumber
        ];

        try {
            $response = Http::timeout(5)->withToken($this->getAuthToken())->get($this->getApiUrl(), $queryParameters);
        } catch (\Exception $exception) {
            return [];
        }

        if ($response->failed()) {
            return [];
        }

        return (new Response($response->json('usage_records', []), array_merge($queryParameters, ['fees' => $fees])))->toArray();

    }


}
