<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autenticación básica
$username = 'admin';
$password = 'password';

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $username || $_SERVER['PHP_AUTH_PW'] !== $password) {
    header('WWW-Authenticate: Basic realm="Acceso restringido"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Acceso denegado.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Ubicaciones</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Ubicaciones Recibidas</h1>
    <table>
        <tr>
            <th>IP</th>
            <th>Ciudad</th>
            <th>Región</th>
            <th>País</th>
            <th>Coordenadas</th>
            <th>Fecha y Hora</th>
        </tr>
        <?php
        $file = 'locations.txt';
        if (file_exists($file)) {
            $locations = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($locations as $location) {
                $data = json_decode($location, true);
                if (is_array($data)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($data['ip'] ?? 'Desconocido') . '</td>';
                    echo '<td>' . htmlspecialchars($data['city'] ?? 'Desconocida') . '</td>';
                    echo '<td>' . htmlspecialchars($data['region'] ?? 'Desconocida') . '</td>';
                    echo '<td>' . htmlspecialchars($data['country'] ?? 'Desconocido') . '</td>';
                    echo '<td>' . htmlspecialchars($data['loc'] ?? 'Desconocida') . '</td>';
                    echo '<td>' . htmlspecialchars($data['timestamp'] ?? 'Desconocida') . '</td>';
                    echo '</tr>';
                } else {
                    echo '<tr><td colspan="6">Error al decodificar JSON</td></tr>';
                }
                
            }
        } else {
            echo '<tr><td colspan="6">No hay datos disponibles.</td></tr>';
        }
        ?>
    </table>
</body>
</html>
