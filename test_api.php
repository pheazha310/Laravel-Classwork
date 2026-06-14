#!/usr/bin/env php
<?php

// Simple API test script
$baseUrl = 'http://127.0.0.1:8000/api';

function makeRequest($method, $endpoint, $data = null) {
    $url = 'http://127.0.0.1:8000/api' . $endpoint;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'body' => json_decode($response, true),
        'raw' => $response
    ];
}

echo "=== Product CRUD API Tests ===\n\n";

// Test 1: GET all products
echo "1. GET /api/products (Get all products)\n";
$result = makeRequest('GET', '/products');
echo "Status: {$result['code']}\n";
echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";

// Test 2: GET single product
if (isset($result['body']['data'][0]['id'])) {
    $productId = $result['body']['data'][0]['id'];
    echo "2. GET /api/products/{$productId} (Get single product)\n";
    $result = makeRequest('GET', "/products/{$productId}");
    echo "Status: {$result['code']}\n";
    echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";
}

// Test 3: POST new product (store)
echo "3. POST /api/products (Create product)\n";
$newProduct = [
    'category_id' => 1,
    'name' => 'Test Laptop',
    'price' => 999.99,
    'stock' => 5,
    'is_active' => true
];
$result = makeRequest('POST', '/products', $newProduct);
echo "Status: {$result['code']}\n";
echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";

// Test 4: PUT/PATCH product (update)
if (isset($result['body']['data']['id'])) {
    $updatedProductId = $result['body']['data']['id'];
    echo "4. PUT /api/products/{$updatedProductId} (Update product)\n";
    $updateData = [
        'name' => 'Updated Laptop',
        'stock' => 10
    ];
    $result = makeRequest('PUT', "/products/{$updatedProductId}", $updateData);
    echo "Status: {$result['code']}\n";
    echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";
    
    // Test 5: DELETE product
    echo "5. DELETE /api/products/{$updatedProductId} (Delete product)\n";
    $result = makeRequest('DELETE', "/products/{$updatedProductId}");
    echo "Status: {$result['code']}\n";
    echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";
}

// Test 6: Validation test - missing required field
echo "6. POST /api/products (Missing required field - should fail)\n";
$invalidProduct = [
    'category_id' => 1,
    'name' => 'Invalid Product'
    // Missing price and stock
];
$result = makeRequest('POST', '/products', $invalidProduct);
echo "Status: {$result['code']}\n";
echo json_encode($result['body'], JSON_PRETTY_PRINT) . "\n\n";

echo "=== Tests Complete ===\n";
