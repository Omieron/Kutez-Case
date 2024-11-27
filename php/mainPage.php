<?php

require_once './api.php';

header("Content-Type: application/json");
$productDataPath = "../db/products.json"; 

$getPrice = getPrice();
if($getPrice != null)
    $data['price'] = $getPrice; // API CALISTIRIYOR
else
    $data['price'] = 0;

 if (file_exists($productDataPath)) {
     $db = file_get_contents($productDataPath); // Veriyi al
     if ($db) {
         $decodedProductData = json_decode($db, true); 

         if (json_last_error() == JSON_ERROR_NONE) {
             
             $method = $_SERVER["REQUEST_METHOD"];
             if ($method != "GET") {
                http_response_code(404);
                echo json_encode(["error" => "Invalid Request Method ($method)"]);
                exit;
            } else {
             
                $data['obj'] = PopularityScore($decodedProductData);//getSelectedJsonData($pos, $value, $decodedProductData);
                echo json_encode(['data' => $data]);
                exit;
             }
         } else {
             echo json_encode(['error' => 'Invalid JSON format']);
             exit;
         }
     } else {
         echo json_encode(['error' => 'JSON file cannot be read']);
         exit;
     }
 } else {
     echo json_encode(['error' => 'JSON file cannot be xxxs found']);
     exit;
 }

function PopularityScore($dataJson){
   
    usort($dataJson, function ($a, $b) {
        return $b['popularityScore'] <=> $a['popularityScore']; // Büyükten küçüğe sıralama
    });

    return $dataJson;
}

