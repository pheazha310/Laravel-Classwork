#!/usr/bin/env php
<?php

$response = file_get_contents('http://127.0.0.1:8000/api/products/1');
$data = json_decode($response, true);

echo "Full Response:\n";
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

echo "Product Fields:\n";
if (isset($data['data'])) {
    foreach (array_keys($data['data']) as $field) {
        echo "  - $field\n";
    }
}
