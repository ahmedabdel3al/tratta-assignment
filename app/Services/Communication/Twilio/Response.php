<?php

namespace App\Services\Communication\Twilio;

use App\Services\Communication\Contract\ResponseInterface;
use Illuminate\Support\Str;

class Response implements ResponseInterface
{

    public function __construct(protected array $responseData,
                                protected array $queryParameters = [])
    {
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->findByCategory('calls-inbound', 'sms-inbound-longcode')
            //convert calls-inbound to calls_inbound as key
            ->flatMap(fn($value, $key) => [Str::of($key)->lower()->slug('_')->value() => CategoryResponse::toArray($value, $this->findFeeByCategoryKey($key))])
            ->merge(['request' => $this->queryParameters])
            ->toArray();


    }

    /**
     * @param string $key
     * @return float|null
     */
    private function findFeeByCategoryKey(string $key): float|null
    {
        // put rule between categories and request fee
        // for calls-inbound category the request calls-inbound will be calls_inbound_fee
        // get calls_inbound_fee values from fee array
        $key = Str::of($key)->lower()->slug('_')->append('_fee');
        $fees = data_get($this->queryParameters, 'fees', []);

        return data_get($fees, $key, 1);
    }

    /**
     * @param string $category
     * @return \Illuminate\Support\Collection|\Illuminate\Support\Traits\EnumeratesValues
     */
    private function findByCategory(string $category)
    {
        $categories = func_get_args();
        return collect($this->responseData)
            ->filter(fn($response, $key) => in_array(data_get($response, 'category'), $categories))
            ->flatMap(fn($value, $key) => [data_get($value, 'category') => $value]);
    }

}
