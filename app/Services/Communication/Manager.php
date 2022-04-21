<?php

namespace App\Services\Communication;

use App\Services\Communication\Contract\CommunicationProviderInterface;
use App\Services\Communication\Twilio\Twilio;
use Illuminate\Support\Facades\Facade;

class Manager extends Facade
{

    public $providers = [];


    public function make(string $provider): CommunicationProviderInterface
    {
        $provider = strtolower($provider);

        return $this->get($provider) ?: $this->resolve($provider);
    }

    /**
     * @param string $provider
     * @return CommunicationProviderInterface | null
     */
    protected function get(string $provider): CommunicationProviderInterface | null
    {
        return data_get($this->providers,$provider, null);
    }


    /**
     * @param $provider
     * @return mixed
     * @throws \Exception
     */
    protected function resolve(string $provider)
    {
        $method = 'create' . ucfirst($provider) . 'Provider';

        if (!method_exists($this, $method)) {
            throw  new \Exception("No Declaration Available For $provider Provider");
        }

        return $this->$method($provider);
    }


    protected function createTwilioProvider(string $provider): CommunicationProviderInterface
    {
      return $this->providers[$provider] = new Twilio();
    }

}
