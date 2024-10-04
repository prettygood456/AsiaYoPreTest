<?php

dataset('order test cases', [
    // 成功案例：使用 TWD 付款
    [
        'payload' => [
            "id" => "A0000001",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "2000",
            "currency" => "TWD"
        ],
        'expected_status' => 201,
        'expected_response' => [
            "id" => "A0000001",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => 2000,
            "currency" => "TWD"
        ],
        'expected_errors' => ''
    ],
    // 成功案例：使用 USD 付款並轉換為 TWD
    [
        'payload' => [
            "id" => "A0000002",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "50",
            "currency" => "USD"
        ],
        'expected_status' => 201,
        'expected_response' => [
            "id" => "A0000002",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => 1550,
            "currency" => "TWD"
        ],
        'expected_errors' => ''
    ],
    // 失敗案例：名稱包含非英文字母
    [
        'payload' => [
            "id" => "A0000003",
            "name" => "Melody Holiday Inn 台灣",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "2000",
            "currency" => "TWD"
        ],
        'expected_status' => 400,
        'expected_response' => '',
        'expected_errors' => [
            "Name contains non-English characters."
        ]
    ],
    // 失敗案例：名稱的單字首字母未大寫
    [
        'payload' => [
            "id" => "A0000004",
            "name" => "melody holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "2000",
            "currency" => "TWD"
        ],
        'expected_status' => 400,
        'expected_response' => '',
        'expected_errors' => [
            "Name is not capitalized."
        ]
    ],
    // 失敗案例：價格超過 2000
    [
        'payload' => [
            "id" => "A0000005",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "2500",
            "currency" => "TWD"
        ],
        'expected_status' => 400,
        'expected_response' => '',
        'expected_errors' => [
            "Price is over 2000."
        ]
    ],
    // 失敗案例：使用 USD 付款並轉換為 TWD 但價格超過 2000
    [
        'payload' => [
            "id" => "A0000005",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "100",
            "currency" => "USD"
        ],
        'expected_status' => 400,
        'expected_response' => '',
        'expected_errors' => [
            "Price is over 2000."
        ]
    ],
    // 失敗案例：貨幣格式錯誤
    [
        'payload' => [
            "id" => "A0000006",
            "name" => "Melody Holiday Inn",
            "address" => [
                "city" => "taipei-city",
                "district" => "da-an-district",
                "street" => "fuxing-south-road"
            ],
            "price" => "2000",
            "currency" => "EUR"
        ],
        'expected_status' => 400,
        'expected_response' => '',
        'expected_errors' => [
            "Currency format is wrong."
        ]
    ],
]);


it('Test', function ($payload, $expected_status, $expected_response, $expected_errors) {
    $response = $this->postJson('/api/orders', $payload);

    $response->assertStatus($expected_status);

    if ($expected_status === 201) {
        $response->assertJson($expected_response);
    } elseif ($expected_status) {
        $response->assertJson([
            "errors" => $expected_errors
        ]);
    }
})->with('order test cases');



