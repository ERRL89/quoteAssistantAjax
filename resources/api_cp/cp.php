<?php

if(isset($_POST['codigoPostal'])){
    $cp=$_POST['codigoPostal'];
}

$url = 'https://api.tau.com.mx/dipomex/v1/codigo_postal';
$apiKey = '6d4b62f41003318f37611e81806cc6eb51e9428d';

$ch = curl_init($url . '?cp=' . $cp);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'APIKEY: ' . $apiKey
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error al realizar la solicitud: ' . curl_error($ch);
} else {
    $decodedResponse = json_decode($response, true);

    if ($decodedResponse === null) {
        echo json_encode(array('error' => true, 'message' => 'Error al decodificar la respuesta JSON'));
    } else {
        header('Content-Type: application/json'); // Establecer el tipo de contenido como JSON
        echo json_encode($decodedResponse);
    }
}

curl_close($ch);

?>
