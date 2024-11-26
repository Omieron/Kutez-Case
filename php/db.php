 <?php

    $productDataPath = "../js/products.json"; //path of data

    if(file_exists($productDataPath)){
        
        $productData = file_get_contents($productDataPath); // get data

        if($productData){

            $decodedProductData = json_decode($productData, true);
             if(json_last_error() === JSON_ERROR_NONE){

                header('Content-Type: application/json');
                echo json_encode($decodedProductData);
                exit;
            } else {

                echo json_encode(['error' => 'Invalid JSON format']);
                exit;
            }
        } else {

            echo json_encode(['error' => 'JSON file cannot read']);
            exit;
        }
    } else {
        
        echo json_encode(['error' => 'JSON file cannot find!!!']);
        exit;
    }
