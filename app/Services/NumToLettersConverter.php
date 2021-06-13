<?php

namespace App\Services;

class NumToLettersConverter
{

  /**
   * Number translation table.
   *
   *
   * @var array
   */
  public static $nums = [
    1 => 'A',
    2 => 'B',
    3 => 'C',
    4 =>'D',
    5 =>'E',
    6 =>'F',
    7 =>'G',
    8 =>'H',
    9 =>'I',
    10 =>'J',
    11 =>'K',
    12 =>'L',
    13 =>'M',
    14 =>'N',
    15 =>'O',
    16 =>'P',
    17 =>'Q',
    18 =>'R',
    19 =>'S',
    20 =>'T',
    21 =>'U',
    22 =>'V',
    23 =>'W',
    24 =>'X',
    25 =>'Y',
    26 =>'Z',
  ];


  /**
   * Get the excel string representation of a number or
   * array of numbers
   *
   * @param int|array $value
   * @return string|array
  */

  public static function getExcelStringFormat($value)
  {

    if(is_int($value)){
      return self::convertNumberToExcelString($value);
    }

    if (is_array($value)) {
      return self::convertArrayElementsToExcelString($value);
    }

    return null;
  }


  /**
   * Convert each element in the array to excel string format
   * and return a new array
   *
   * @param array $value
   * @return array $excel_string_array
  */
  private static function convertArrayElementsToExcelString(array $nums){
    $excel_string_array = [];

    foreach ($nums as $num) {
      $excel_string_array[] = self::convertNumberToExcelString($num);
    }

    return $excel_string_array;
  }


  /**
   * Convert number to excel string format
   *
   * @param int $value
   * @return string $excel_string
  */
  private static function convertNumberToExcelString(int $num){
    $excel_string = [];

    while ($num > 0) {
      $remainder = $num % 26;

      if ($remainder == 0) {
          $excel_string[] = self::$nums[26];
          $num = floor($num / 26) - 1;
      }else{
          $excel_string[] = self::$nums[$remainder];
          $num = floor($num / 26);
      }
    }

    return implode("",array_reverse($excel_string));
  }
}



