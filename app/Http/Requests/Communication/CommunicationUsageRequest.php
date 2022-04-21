<?php

namespace App\Http\Requests\Communication;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CommunicationUsageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $dataShouldPushedToRequest = [];
        if (is_null($this->get('account_number'))) {
            $dataShouldPushedToRequest['account_number'] = 'AC977a3102fe6a45dd7dd2b70895049f7f';
        }

        if (is_null($this->get('start_date'))) {
            $dataShouldPushedToRequest['start_date'] = Carbon::now()->subDays(7)->format('Y-m-d');
        }

        if (is_null($this->get('end_date'))) {
            $dataShouldPushedToRequest['end_date'] = Carbon::now()->format('Y-m-d');
        }

        $dataShouldPushedToRequest['fees']['calls_inbound_fee'] = $this->get('calls_inbound_fee', 1);
        $dataShouldPushedToRequest['fees']['sms_inbound_longcode_fee'] = $this->get('sms_inbound_longcode_fee', 1);


        $this->merge($dataShouldPushedToRequest);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_number' => 'string',
            'start_date' => 'date|date_format:Y-m-d',
            'end_date' => 'date|date_format:Y-m-d',
            'fees' => 'sometimes|array'
        ];
    }
}
