<?php

 header("Content-Type: application/json");

 $productDataPath = "../db/products.json"; // Verinin yolu

 // Veriyi almak için dosyanın var olup olmadığını kontrol et
 if (file_exists($productDataPath)) {

     $db = file_get_contents($productDataPath); // Veriyi al

     if ($db) {

         $decodedProductData = json_decode($db, true); // JSON'u çözümle

         // JSON hatası olup olmadığını kontrol et
         if (json_last_error() == JSON_ERROR_NONE) {

             // GET isteği kontrolü
             // $method = $_SERVER["REQUEST_METHOD"];
             // if ($method != "GET") {
             //     http_response_code(404);
             //     echo json_encode(["error" => "Invalid Request Method ($method)"]);
             //     exit;
             // }

             // Parametreler ile veriyi almak (isteğe bağlı)
             $value = 4;
             $pos = 0;

             // URL parametrelerinden veri alabilirsiniz
             // $value = isset($_GET['value']) ? (int) $_GET['value'] : 4;
             // $pos = isset($_GET['pos']) ? (int) $_GET['pos'] : 0;

             // Veriyi işlemek için fonksiyonu çağır
             $data = getSelectedJsonData($pos, $value, $decodedProductData);


             // Veriyi JSON formatında döndür
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

 // Veriyi alırken sadece belirli bir kısmı döndüren fonksiyon
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


