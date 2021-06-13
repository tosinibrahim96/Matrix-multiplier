<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\MultiplyMatricesRequest;
use App\Services\MatrixService;
use Illuminate\Http\Response;

class MatrixController extends Controller {


  protected $matrix_service, $num_to_letters_converter;

  /**
   * Create a new controller instance.
   *
   * @param  App\Services\MatrixService  $matrix_service
   * @return void
   */
  public function __construct(
    MatrixService $matrix_service
    )
  {
      $this->matrix_service = $matrix_service;
  }

  /**
   * Multiply the matrices sent from the client
   *
   * @param  App\Http\Requests\MultiplyMatricesRequest  $request
   * @return Illuminate\Http\JsonResponse
   */
  public function multiply(MultiplyMatricesRequest $request)
  {
    $matrix_result = $this->matrix_service->multiplyMatrices($request->all());
    return ApiResponse::send(
      Response::HTTP_OK,
      [
        "matrix" =>$matrix_result,
        'rows_count' => count($matrix_result),
        'columns_count' => count($matrix_result[0])
      ],
      "New matrix generated successfully."
    );
  }
}
