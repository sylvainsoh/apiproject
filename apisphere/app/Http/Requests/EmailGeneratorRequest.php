<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Psy\Exception\ErrorException;

class EmailGeneratorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'expression' => 'required|string'
        ];
    }

    /**
     * @Override
     *
     * @param string $key
     * @param string $default
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        //Parent validator
        $data = parent::validated($key, $default);

        //Get inputs
        $inputs = $this->getInputs($this->all());

        //Check expression inputs
        $this->validateExpressionInputs($inputs, $data['expression']);

        //Return formatted data
        return [
            'inputs' => $inputs,
            'expression' => $data['expression'],
        ];
    }

    /**
     * Check that all inputs in the expression are specified in the request
     *
     * @param array $inputs
     * @param string $expression
     * @return bool
     * @throws HttpResponseException
     */
    private function validateExpressionInputs(array $inputs, string $expression): bool
    {
        //Get matches
        $matches = [];
        preg_match_all('/(\$)(input\d+)/', $expression, $matches);

        //Check matches exist in inputs
        foreach ($matches[2] as $inputName) {
            if(!array_key_exists($inputName, $inputs)) {
                throw new HttpResponseException(response()->json([
                    'error' => $inputName . ' is used in the expression but not specified in the parameters',
                ], Response::HTTP_UNPROCESSABLE_ENTITY));
            }
        }

        //Return
        return true;
    }

    /**
     * Get inputs from request
     *
     * @param array $data
     * @return array
     * @throws ErrorException
     */
    private function getInputs(array $data): array
    {
        //Get inputs
        $inputs = [];
        foreach ($data as $key => $value) {
            if (isset($value)) {
                if (str_starts_with($key, 'input')) {
                    $inputs[$key] = $value;
                }
            } else {
                throw new ErrorException('The field ' . $key . ' is empty');
            }
        }
        //Return
        return $inputs;
    }
}
