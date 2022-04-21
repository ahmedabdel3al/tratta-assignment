<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\CommunicationUsageRequest;
use App\Services\Communication\Contract\CommunicationProviderInterface;

class CommunicationUsageController extends Controller
{
    public function __invoke(CommunicationUsageRequest $request, CommunicationProviderInterface $communication)
    {

        $responseData = $communication->getUsageRecords($request->get('account_number'), $request->get('start_date'), $request->get('end_date'), $request->get('fees', []));
        return response()->json(['data' => $responseData]);
    }
}
