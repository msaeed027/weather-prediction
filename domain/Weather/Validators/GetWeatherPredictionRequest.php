<?php

namespace Domain\Weather\Validators;

use App\Http\Requests\BaseRequestValidator;

class GetWeatherPredictionRequest extends BaseRequestValidator
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'city' => 'required',
            'date' => "required|date_format:Y-m-d|after_or_equal:today|before:+10 day"
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['city'] = $this->query('city');
        $data['date'] = $this->query('date');
        return $data;
    }
}
