<?php

namespace Tests\Feature\MatrixMultiplication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatrixProductTest extends TestCase
{

  use RefreshDatabase;

  /**
   * Successful matrix multiplication attempt
   *
   * @return void
   */
  public function test_user_multiplymatrix_successful()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response = $this->post('/api/v1/matrix/multiply',
        [

            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response->assertStatus(200);
    $response->assertExactJson(
      [
        "status" => 200,
        "data" => [
            "matrix" => [
                [
                    "F",
                    "O",
                    "X",
                    "AG"
                ],
                [
                    "L",
                    "AD",
                    "AV",
                    "BN"
                ]
            ],
            "rows_count" =>  2,
            "columns_count" => 4
        ],
        "message" => "New Matrix Generated Successfully."
      ]);
  }


  /**
   * Multiply matrix attempt without valid token
   *
   * @return void
   */
  public function test_user_multiplymatrix_unauthorized()
  {
      $logout_response = $this->post('/api/v1/matrix/multiply',
          [],
          [
              "Accept" => "application/json",
          ]
      );
      $logout_response->assertStatus(401);
      $logout_response->assertExactJson([
          "status" => 401,
          "error" => "Unauthorized",
          "message" => "Access Denied. You Are Not Presently Authorized To Use This System Function."
      ]);
  }


   /**
   * matrix1_row_count must be part of the request
   * matrix1_row_count must be a number
   * matrix1_row_count must be greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix1_row_count_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix1_row_count' => [
            'The matrix1 row count field is required.'
          ]
        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => "a",
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix1_row_count' => [
            'The matrix1 row count must be a number.',
            'The matrix1 row count must be an integer.'
          ]
        ]
    ]);



    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 0,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix1_row_count' => [
            'The matrix1 row count must be at least 1.'
          ]
        ]
    ]);
  }


   /**
   * matrix1_column_count must be part of the request
   * matrix1_column_count must be a number
   * matrix1_column_count must be greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix1_column_count_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix1_column_count' => [
            'The matrix1 column count field is required.'
          ],
          'matrix2_row_count' => [
            'The number of columns in matrix 1 must match the number of rows in matrix 2'
          ]
        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => "b",
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix2_row_count' => [
            'The number of columns in matrix 1 must match the number of rows in matrix 2'
          ],
          'matrix1_column_count' => [
            'The matrix1 column count must be a number.',
            'The matrix1 column count must be an integer.'
          ],
        ]
    ]);



    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 0,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix1_column_count' => [
            'The matrix1 column count must be at least 1.'
          ]
        ]
    ]);
  }



   /**
   * matrix2_row_count must be part of the request
   * matrix2_row_count must be a number
   * matrix2_row_count must be greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix2_row_count_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_column_count" => 3,
            "matrix1_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix2_row_count' => [
            'The matrix2 row count field is required.'
          ]
        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 4,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => "c",
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix2_row_count' => [
            'The matrix2 row count must be a number.',
            'The matrix2 row count must be an integer.'
          ]
        ]
    ]);



    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 4,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 0,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix2_row_count' => [
            'The matrix2 row count must be at least 1.'
          ]
        ]
    ]);
  }


  /**
   * matrix2_column_count must be part of the request
   * matrix2_column_count must be a number
   * matrix2_column_count must be greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix2_column_count_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix2_row_count" => 4,
            "matrix1_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix2_column_count' => [
            'The matrix2 column count field is required.'
          ]

        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => "c",
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix2_column_count' => [
            'The matrix2 column count must be a number.',
            'The matrix2 column count must be an integer.'
          ],
        ]
    ]);



    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 0,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix2_column_count' => [
            'The matrix2 column count must be at least 1.'
          ]
        ]
    ]);


    $response4 = $this->post('/api/v1/matrix/multiply',
      [
          "matrix1_row_count" => 2,
          "matrix1_column_count" => 1,
          "matrix2_row_count" => 3,
          "matrix2_column_count" => 4,
          "matrix1_data" => [1,1,1,2,2,2],
          "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
      ],
      [
          "Accept" => "application/json",
          "Authorization" => "Bearer $token"
      ]
    );

    $response4->assertStatus(422);
    $response4->assertJson(
      [
        'errors' => [
          'matrix1_data' => [
            'matrix1 data expects an array of 2 numbers to construct a matrix with 2 rows and 1 columns'
          ],
          'matrix2_row_count' => [
            'The number of columns in matrix 1 must match the number of rows in matrix 2'
          ]

        ]
    ]);
  }


   /**
   * matrix1_data must be part of the request
   * matrix1_data must be an array
   * All values in matrix1_data must be numbers greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix1_data_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_column_count" => 3,
            "matrix1_row_count" => 2,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix1_data' => [
            'The matrix1 data field is required.'
          ]
        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => 5,
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix1_data' => [
            'The matrix1 data must be an array.',
            'matrix1 data expects an array of 6 numbers to construct a matrix with 2 rows and 3 columns'
          ]
        ]
    ]);


    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => ["a",0,1,2,2,2],
            "matrix2_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix1_data.0' => [
            'The matrix1_data.0 must be a number.'
          ],
          'matrix1_data.1' => [
            'The matrix1_data.1 must be at least 1.'
          ]
        ]
    ]);
  }


    /**
   * matrix2_data must be part of the request
   * matrix2_data must be an array
   * All values in matrix2_data must be numbers greater than or equal to 1
   *
   * @return void
   */
  public function test_user_multiplymatrix_matrix2_data_validations()
  {
    $register_response = $this->post('/api/v1/register',
      [
          "name" => "Test name",
          "email" => "testemail@mail.com",
          "password" => "password",
          "password_confirmation" => "password"
      ],
      [
          "Accept" => "application/json"
      ]
    );

    $token = json_decode($register_response->getContent())->data->token;
    $response1 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_column_count" => 3,
            "matrix1_row_count" => 2,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,4,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response1->assertStatus(422);
    $response1->assertJson(
      [
        'errors' => [
          'matrix2_data' => [
            'The matrix2 data field is required.'
          ]
        ]
    ]);



    $response2 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix1_data" => [1,1,1,2,2,2],
            "matrix2_data" => 2
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response2->assertStatus(422);
    $response2->assertJson(
      [
        'errors' => [
          'matrix2_data' => [
            'The matrix2 data must be an array.',
            'matrix2 data expects an array of 12 numbers to construct a matrix with 3 rows and 4 columns'
          ]
        ]
    ]);


    $response3 = $this->post('/api/v1/matrix/multiply',
        [
            "matrix1_row_count" => 2,
            "matrix1_column_count" => 3,
            "matrix2_row_count" => 3,
            "matrix2_column_count" => 4,
            "matrix2_data" => [1,1,1,2,2,2],
            "matrix2_data" => ["a",0,7,10,2,5,8,11,3,6,9,12]
        ],
        [
            "Accept" => "application/json",
            "Authorization" => "Bearer $token"
        ]
    );

    $response3->assertStatus(422);
    $response3->assertJson(
      [
        'errors' => [
          'matrix2_data.0' => [
            'The matrix2_data.0 must be a number.'
          ],
          'matrix2_data.1' => [
            'The matrix2_data.1 must be at least 1.'
          ]
        ]
    ]);
  }

}
