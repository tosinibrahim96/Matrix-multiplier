<?php

namespace Tests\Unit;

use App\Services\MatrixService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class MatrixServiceTest extends TestCase
{

  use RefreshDatabase;


  /**
   * @param $object
   * @param string $method
   * @param array $parameters
   * @return mixed
   * @throws \Exception
   */
  private function callMethod($object, string $method , array $parameters = [])
  {
      try {
          $className = get_class($object);
          $reflection = new \ReflectionClass($className);
      } catch (\ReflectionException $e) {
          throw new \Exception($e->getMessage());
      }

      $method = $reflection->getMethod($method);
      $method->setAccessible(true);

      return $method->invokeArgs($object, $parameters);
  }


  /**
   * Successful Generate matrix structure from array
   *
   * @return void
   */
  public function test_generate_matrix_structure_success()
  {
    $arr = [1,2,3,4,5,6];
    $number_of_columns = 2;
    $expected_matrix_structure = [[1,2],[3,4],[5,6]];
    $actual_matrix_structure = $this->callMethod(new MatrixService(),'generateMatrixStructure',[$arr, $number_of_columns]);
    $this->assertEquals($expected_matrix_structure, $actual_matrix_structure);
  }

  /**
   * Throw type error exception when wrong parameter types are passed
   *
   * @return void
   */
  public function test_generate_matrix_structure_without_array()
  {
    $arr = 5;
    $number_of_columns = 2;
    $this->expectException(TypeError::class);
    $this->callMethod(new MatrixService(),'generateMatrixStructure',[$arr, $number_of_columns]);
  }


   /**
   * Throw type error exception when wrong parameter types are passed
   *
   * @return void
   */
  public function test_generate_matrix_structure_without_integer()
  {
    $arr = [1,2,3,4,5,6];
    $number_of_columns = "string";
    $this->expectException(TypeError::class);
    $this->callMethod(new MatrixService(),'generateMatrixStructure',[$arr, $number_of_columns]);
  }

}
