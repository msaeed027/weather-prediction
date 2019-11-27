<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

abstract class BaseRequestValidator
{
    public $errors = [];

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $validator;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function validate(Request $request)
    {
        $this->validator = Validator::make($request->all(), $this->rules(), $this->messages());

        return $this;
    }

    /**
     * @return bool Or array of errors
     */
    public function failed()
    {
        if (!isset($this->validator)) {
            $this->validate(app('request'));
        }

        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors()->messages();

            return $this->getErrors();
        }

        return false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->mapErrors($this->errors);
    }

    /**
     * @param array $errors
     *
     * @return array
     */
    private function mapErrors(array $errors): array
    {
        $formattedErrors = [];

        foreach ($errors as $field => $messages) {
            $inputErrors = array_map(function ($message) use ($field) {
                return [
                    'field' => $this->mapFieldName($field),
                    'message' => $message,
                ];
            }, $messages);

            $formattedErrors = array_merge($inputErrors, $formattedErrors);
        }

        return $formattedErrors;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract protected function rules();

    /**
     * Override the validation messages.
     *
     * @return array
     */
    protected function messages(): array
    {
        return [];
    }
    
    /**
     * Append a rule to the rules array for validation
     * 
     * @param string $field
     * @param string $rule
     */
    protected function addRule(string $field, string $rule)
    {
        // If rule is not defined 
        $this->rules[$field] = $this->rules[$field] ?? [];
        array_push($this->rules[$field], $rule);
    }
    
    /**
     * Change field name if required
     * 
     * @param string $field
     * @return string The mapped field name
     */
    protected function mapFieldName(string $field)
    {
        return $field;
    }
}
