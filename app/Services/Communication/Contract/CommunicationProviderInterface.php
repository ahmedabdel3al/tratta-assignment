<?php

namespace App\Services\Communication\Contract;

interface CommunicationProviderInterface
{
    public function getUsageRecords(string $accountNumber, string $startDate, string $endDate, array $fees = []): array;
}
