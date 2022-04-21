<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class CommunicationUsageTest extends TestCase
{

    public function test_response_will_contain_categories_as_keys()
    {
        $response = $this->get('/api/communication');

        $response->assertJsonStructure(['data' => ['calls_inbound', 'sms_inbound_longcode']]);
    }

    public function test_response_will_contain_request_params()
    {
        $requests = ['account_number' => 'AC977a3102fe6a45dd7dd2b70895049f7f'];
        $response = $this->call('get', '/api/communication', $requests);

        $response->assertJsonStructure(['data' => ['request']]);
        $response->assertJson(['data' => ['request' => $requests]]);
    }

    public function test_response_structure_of_category_will_be_as_expected()
    {
        $response = $this->get('/api/communication');
        $expected = ['data' => [
            'calls_inbound' => ['count', 'usage', 'usage_unit', 'price', 'tratta_price'],
            'sms_inbound_longcode' => ['count', 'usage', 'usage_unit', 'price', 'tratta_price']
        ]];

        $response->assertJsonStructure($expected);

    }


    public function test_it_will_set_default_account_number_if_request_does_not_have_account_number()
    {
        $response = $this->get('/api/communication');
        $response->assertJson(['data' => ['request' => ['account_number' => 'AC977a3102fe6a45dd7dd2b70895049f7f']]]);

        $this->assertEquals(data_get($response, 'data.request.account_number'), 'AC977a3102fe6a45dd7dd2b70895049f7f');
    }

    public function test_it_will_not_set_default_account_number_if_request_have_account_number()
    {
        $response = $this->call('get', "/api/communication", ['account_number' => '123456789']);

        $this->assertNotEquals(data_get($response, 'data.request.account_number'), 'AC977a3102fe6a45dd7dd2b70895049f7f');
        $this->assertEquals('123456789', data_get($response, 'data.request.account_number'));
    }

    public function test_it_will_set_default_start_date_if_request_does_not_have_start_date()
    {
        $response = $this->get('/api/communication');
        
        $response->assertJson(['data' => ['request' => ['start_date' => (string)Carbon::now()->subDays(7)->format('Y-m-d')]]]);
    }

    public function test_it_will_not_set_default_value_for_start_date_if_request_have_a_valid_start_date()
    {
        $response = $this->call('get', '/api/communication', ['start_date' => Carbon::now()->subDay(8)->format('Y-m-d')]);
        $this->assertNotEquals(data_get($response, 'data.request.start_date'), Carbon::now()->subDays(7)->format('Y-m-d'));

    }

    public function test_it_will_set_default_end_date_if_request_does_not_have_end_date()
    {
        $response = $this->call('get', '/api/communication', []);
        $response->assertJson(['data' => ['request' => ['end_date' => (string)Carbon::now()->format('Y-m-d')]]]);
    }

    public function test_it_will_not_set_default_end_date_if_request_have_end_date()
    {
        $response = $this->call('get', '/api/communication', ['end_date' => $end_date = Carbon::now()->subDay()->format('Y-m-d')]);
        $this->assertNotEquals((string)Carbon::now()->format('Y-m-md'), (string)data_get($response, 'data.request.end_date'));
        $this->assertEquals($end_date, (string)data_get($response, 'data.request.end_date'));
    }

    public function test_it_response_contain_tartta_price_for_categories()
    {
        $response = $this->call('get', '/api/communication', []);
        $response->assertJsonStructure(['data' => ['calls_inbound' => ['tratta_price'], 'sms_inbound_longcode' => ['tratta_price']]]);
    }


    public function test_it_tratta_price_is_calculate_based_on_fee_and_usage_for_sms_inbound()
    {
        $fees = ['sms_inbound_longcode_fee' => 0.5, 'calls_inbound_fee' => 0.3];
        $response = $this->call('get', '/api/communication', $fees);

        //sms tratta price
        $tratta_price_for_sms = data_get($response, 'data.sms_inbound_longcode.tratta_price');
        $sms_usage = data_get($response, 'data.sms_inbound_longcode.usage');
        $this->assertEquals($sms_usage * $fees['sms_inbound_longcode_fee'], $tratta_price_for_sms);

        //calls_inbound tratta price
        $tratta_price_for_call = data_get($response, 'data.sms_inbound_longcode.tratta_price');
        $call_usage = data_get($response, 'data.sms_inbound_longcode.usage');
        $this->assertEquals($call_usage * $fees['sms_inbound_longcode_fee'], $tratta_price_for_call);
    }


}
