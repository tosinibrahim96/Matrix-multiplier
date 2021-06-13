<?php

namespace App\Http\Requests\Rules;

use Illuminate\Contracts\Validation\Rule;

class MatrixDataSizeIsAccurate implements Rule
{

  protected $matrix_column_size, $matrix_row_size;

  protected $expected_matrix_size, $actual_matrix_size;

  /**
   * Create a new instance.
   *
   * @param  int  $matrix_row_size
   * @param  int  $matrix_column_size
   * @return void
   */
  public function __construct($matrix_row_size, $matrix_column_size )
  {
    $this->matrix_row_size = $matrix_row_size;
    $this->matrix_column_size = $matrix_column_size;

  }

  /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){

      $this->expected_matrix_size = $this->matrix_row_size * $this->matrix_column_size;
      if (!is_array($value)) {
        return false;
      }

      $this->actual_matrix_size = count($value);
      return $this->expected_matrix_size == $this->actual_matrix_size;
    }


    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message(){

      return ":attribute expects an array of $this->expected_matrix_size numbers to construct a matrix with $this->matrix_row_size rows and $this->matrix_column_size columns";
    }
}
