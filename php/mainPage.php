<?php

header("Content-Type: application/json");
$productDataPath = "../db/products.json"; 
$data['price'] = getDataFromAPI(); // API CALISTIRIYOR

 if (file_exists($productDataPath)) {
     $db = file_get_contents($productDataPath); // Veriyi al
     if ($db) {
         $decodedProductData = json_decode($db, true); 
         // JSON hatası olup olmadığını kontrol et
         if (json_last_error() == JSON_ERROR_NONE) {
             // GET isteği kontrolü
             // $method = $_SERVER["REQUEST_METHOD"];
             // if ($method != "GET") {
             //     http_response_code(404);
             //     echo json_encode(["error" => "Invalid Request Method ($method)"]);
             //     exit;
             // }
             $value = 4;
             $pos = 0;
             // $value = isset($_GET['value']) ? (int) $_GET['value'] : 4;
             // $pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;
             $data['obj'] = getSelectedJsonData($pos, $value, $decodedProductData);
             echo json_encode(['arr' => $data]);
             exit;
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

// Json dbden gelen veriyi arraye atıyor
function getSelectedJsonData($position, $show, $dataJson) {
     $result = [];
     for ($i = $position; $i < ($show + $position); $i++) {
         if (isset($dataJson[$i])) {
             $result[$i] = [
                 "name" => $dataJson[$i]["name"],
                 "popularityScore" => $dataJson[$i]["popularityScore"],
                 "weight" => $dataJson[$i]["weight"],
                 "images" => $dataJson[$i]["images"]
             ];
         }
     }
    return $result;
}

// GOLD API data alıyor
function getDataFromAPI(){
    $apiKey = "goldapi-c1rg6osm3yf2ucc-io";
    $symbol = "XAU";
    $curr = "USD";
    $date = "";
    $myHeaders = array(
        'x-access-token: ' . $apiKey,
        'Content-Type: application/json'
    );
    $curl = curl_init();
    $url = "https://www.goldapi.io/api/{$symbol}/{$curr}/{$date}";
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => $myHeaders
    ));
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
        return 'Error: ' . $error;
    } else {
        return $response;
    }
}


