<?php

// API Key obtenida desde tu cuenta en Plant.id
$apiKey = 'lnuUNQJxXs2TU3hXVpM3o2q6jIwtZfIQr71nqpEbibM7P5NAJW'; // Reemplaza esto con tu API key

// Verificar si hay una imagen enviada mediante POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos de la imagen en base64
    $imageData = $_POST['image'];

    // Preparar la solicitud cURL
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.plant.id/v3/identification',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(array(
          "images" => ["data:image/jpg;base64," . $imageData],  // Formato requerido para la imagen
          "latitude" => 49.207,  // Puedes eliminar las coordenadas si no son necesarias
          "longitude" => 16.608,
          "similar_images" => true
      )),
      CURLOPT_HTTPHEADER => array(
        'Api-Key: ' . $apiKey,  // Incluye la API Key en los headers
        'Content-Type: application/json'
      ),
    ));

    // Ejecutar la solicitud
    $response = curl_exec($curl);

    // Verificar si ocurrió algún error
    if ($response === false) {
        echo json_encode(['error' => curl_error($curl)]);
        curl_close($curl);
        exit;
    }

    // Cerrar cURL
    curl_close($curl);

    // Decodificar la respuesta JSON
    $responseData = json_decode($response, true);

    // Devolver los datos de la planta como JSON
    echo json_encode($responseData);
}
?>
