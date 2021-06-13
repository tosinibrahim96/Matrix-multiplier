<?php

namespace App\Services;


class MatrixService
{

  protected $matrix1, $matrix1_data_count, $matrix1_row_count, $matrix1_column_count;

  protected $matrix2, $matrix2_data_count, $matrix2_row_count, $matrix2_column_count;

  protected $new_matrix, $newmatrix_expected_row_count, $newmatrix_expected_column_count;




  /**
   * Setup class properties
   *
   * @param array  $request_data
   * @return void
   */
  private function setup(array $request_data){

    $this->matrix1_row_count = $request_data['matrix1_row_count'];
    $this->matrix1_column_count = $request_data['matrix1_column_count'];
    $this->matrix2_row_count = $request_data['matrix2_row_count'];
    $this->matrix2_column_count = $request_data['matrix2_column_count'];
    $this->matrix1_data_count = count($request_data['matrix1_data']);
    $this->matrix2_data_count = count($request_data['matrix2_data']);
    $this->matrix1 = $this->generateMatrixStructure($request_data['matrix1_data'], $this->matrix1_column_count);
    $this->matrix2 = $this->generateMatrixStructure($request_data['matrix2_data'], $this->matrix2_column_count);
    $this->newmatrix_expected_row_count = count($this->matrix1);
    $this->newmatrix_expected_column_count = count($this->matrix2[0]);
  }




  /**
   * Derive the resulting matrix from the request data
   *
   * @param array  $request_data
   * @return array $new_matrix
   */
  public function multiplyMatrices(array $request_data) {

    $this->setup($request_data);
    $this->multiplyMatrixRowsByColumns();
    $this->convertNewMatrixToExcelFormat();
    return $this->new_matrix;
  }


  /**
   * Generate matrix structure from array
   *
   * @param array  $matrix_data
   * @param int  $number_of_columns
   * @return array
   */
  private function generateMatrixStructure(array $matrix_data, int $number_of_columns){

    return array_chunk($matrix_data, $number_of_columns);
  }


  /**
   * Multiply matrix rows by columns
   *
   * @return null|void
   */
  private function multiplyMatrixRowsByColumns(){

    if (($this->matrix1_column_count != $this->matrix2_row_count)
    ||(!is_int($this->matrix1_column_count) || (!is_int($this->matrix2_row_count)))
    ) {
      return null;
    }

    $expected_data = [];
    for ($j=0; $j< $this->matrix1_row_count; $j++) {
      $dot_product = 0;
      $current_matrix1_index = 0;
      $current_matrix2_index = 0;
      for ($i=0; $i < $this->matrix2_data_count; $i++) {
        $dot_product += $this->matrix1[$j][$current_matrix1_index] * $this->matrix2[$current_matrix1_index][$current_matrix2_index];
        $current_matrix1_index+=1;

        if ($current_matrix1_index >= count($this->matrix1[0])) {
          $expected_data[] = $dot_product;
          $current_matrix1_index = 0;
          $dot_product = 0;
          $current_matrix2_index +=1;
        }
      }
    }

    $this->new_matrix = $this->generateMatrixStructure($expected_data, $this->newmatrix_expected_column_count);
  }


  /**
   * Convert new matrix to excel format
   *
   * @return void
   */
  private function convertNewMatrixToExcelFormat(){

    $excel_output = [];
    foreach ($this->new_matrix as $row) {
      $excel_output[] = NumToLettersConverter::getExcelStringFormat($row);
    }

    $this->new_matrix = $excel_output;
  }

}
