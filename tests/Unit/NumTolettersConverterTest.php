<?php

namespace Tests\Unit;

use App\Services\MatrixService;
use App\Services\NumToLettersConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class NumTolettersConverterTest extends TestCase
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
   * Successful get letter representation of a number
   *
   * @return void
   */
  public function test_get_letter_representation_of_number()
  {
    $expected = 'A';
    $actual = NumToLettersConverter::$nums[1];
    $this->assertEquals($expected, $actual);
  }


  /**
   * Return null if the type is not integer or array
   *
   * @return void
   */
  public function test_get_string_format_for_wrong_type()
  {
    $expected = null;
    $actual = NumToLettersConverter::getExcelStringFormat('A');
    $this->assertEquals($expected, $actual);
  }

  /**
   * Return null if the type is not integer or array
   *
   * @return void
   */
  public function test_convert_number_to_string_format()
  {
    $number = 27;
    $expected = 'AA';
    $actual = $this->callMethod(new NumToLettersConverter(),'convertNumberToExcelString',[$number]);
    $this->assertEquals($expected, $actual);
  }

   /**
   * Return null if the type is not integer or array
   *
   * @return void
   */
  public function test_convert_array_elements_to_string_format()
  {
    $arr = [27,28,6,7,12,4];
    $expected = ['AA','AB','F','G','L','D'];
    $actual = $this->callMethod(new NumToLettersConverter(),'convertArrayElementsToExcelString',[$arr]);
    $this->assertEquals($expected, $actual);
  }
}
