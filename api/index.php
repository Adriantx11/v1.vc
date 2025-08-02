<?php
// Endpoint para Vercel - Maneja webhooks de Telegram
require_once("../require.php");

// Obtener el input de Telegram
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log para debugging
error_log("Telegram webhook received: " . $input);

// Verificar que sea una petición válida de Telegram
if (!$data) {
    http_response_code(400);
    echo "Invalid request";
    exit;
}

// Procesar el mensaje usando la lógica existente
try {
    // Incluir la lógica del bot desde el archivo principal
    ob_start();
    include("../index.php");
    $output = ob_get_clean();
    
    // Solo enviar respuesta si hay contenido
    if (!empty($output)) {
        echo $output;
    } else {
        echo "OK";
    }
} catch (Exception $e) {
    error_log("Error processing webhook: " . $e->getMessage());
    http_response_code(500);
    echo "Error processing webhook";
}
?> 