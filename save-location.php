<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método no permitido');
}

$ip = $_SERVER['REMOTE_ADDR'];
$token = 'f01c886651ecad'; // tu token de acceso de IPinfo
$url = "https://ipinfo.io/{$ip}?token={$token}";

$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data) {
    // Añadir fecha y hora a los datos
    $data['timestamp'] = date('Y-m-d H:i:s');
    // Guarda los datos en un archivo de texto
    $file = 'locations.txt';
    $current = file_get_contents($file);
    $current .= json_encode($data) . "\n";
    file_put_contents($file, $current);
    echo 'Ubicación guardada correctamente';
} else {
    echo 'No se pudo obtener la ubicación';
}
?>
