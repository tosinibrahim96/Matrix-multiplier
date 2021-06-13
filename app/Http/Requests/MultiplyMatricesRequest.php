<?php

namespace App\Http\Requests;

use App\Http\ApiRequest;
use App\Http\Requests\Rules\MatrixDataSizeIsAccurate;

class MultiplyMatricesRequest extends ApiRequest
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
            'matrix1_row_count' => 'required|numeric|integer|min:1',
            'matrix1_column_count' => 'required|numeric|integer|min:1',
            'matrix2_row_count' => 'required|numeric|integer|min:1|same:matrix1_column_count',
            'matrix2_column_count' => 'required|numeric|integer|min:1',
            'matrix1_data' => [
              'required',
              'array',
              is_integer($this->matrix1_row_count) && is_integer($this->matrix1_column_count)
              ? new MatrixDataSizeIsAccurate($this->matrix1_row_count, $this->matrix1_column_count)
              :""
            ],
            'matrix2_data' => [
              'required',
              'array',
              is_integer($this->matrix2_row_count) && is_integer($this->matrix2_column_count)
              ?new MatrixDataSizeIsAccurate($this->matrix2_row_count,$this->matrix2_column_count)
              :""
            ],
            'matrix1_data.*' => 'numeric|min:1',
            'matrix2_data.*' => 'numeric|min:1'
        ];
    }


    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages(){

      return [
          'matrix2_row_count.same' => "The number of columns in matrix 1 must match the number of rows in matrix 2"
      ];
    }


}
